<?php

namespace App\Services;

use App\Models\stp_career;
use App\Models\stp_careerAssetSet;
use App\Models\stp_RIASECType;
use App\Models\stp_riasecPosterAssetSet;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class PosterAssetService
{
    private const POSITIONS = ['left', 'center', 'right'];

    public function careerList(): array
    {
        return stp_career::query()->where('status', 1)->orderBy('name')->get()
            ->map(fn ($career) => $this->careerAdminPayload($career))->all();
    }

    public function careerAdminPayload(stp_career $career): array
    {
        $draft = $career->assetSets()->where('status', 'draft')->latest()->first();
        $published = $career->assetSets()->where('status', 'published')->latest('published_at')->first();

        return [
            'id' => $career->id,
            'name' => $career->name,
            'slug' => $career->slug,
            'draft' => $this->careerSetPayload($draft),
            'published' => $this->careerSetPayload($published),
            'ready' => $published ? $this->careerSetComplete($published) : false,
        ];
    }

    public function saveCareerDraft(stp_career $career, array $files): stp_careerAssetSet
    {
        $draft = $career->assetSets()->firstOrCreate(
            ['status' => 'draft'],
            $this->cloneCareerPaths($career->assetSets()->where('status', 'published')->latest('published_at')->first())
        );

        foreach (self::POSITIONS as $position) {
            if (! isset($files[$position]) || ! $files[$position] instanceof UploadedFile) {
                continue;
            }
            $oldSource = $draft->getAttribute("{$position}_source_path");
            $oldRender = $draft->getAttribute("{$position}_image_path");
            [$source, $render] = $this->storeImage($files[$position], "careers/{$career->slug}", $position);
            $draft->setAttribute("{$position}_source_path", $source);
            $draft->setAttribute("{$position}_image_path", $render);
            $this->removeCareerFilesWhenUnused($oldSource, $oldRender, $draft->id);
        }
        $draft->save();

        return $draft->fresh();
    }

    public function publishCareer(stp_career $career, int $adminId): stp_careerAssetSet
    {
        return DB::transaction(function () use ($career, $adminId) {
            $draft = $career->assetSets()->where('status', 'draft')->lockForUpdate()->first();
            if (! $draft || ! $this->careerSetComplete($draft)) {
                throw ValidationException::withMessages(['assets' => ['Left, centre, and right images are required before publishing.']]);
            }
            $career->assetSets()->where('status', 'published')->update(['status' => 'archived']);
            $draft->update(['status' => 'published', 'published_by' => $adminId, 'published_at' => now()]);

            return $draft->fresh();
        });
    }

    public function riasecList(): array
    {
        return stp_RIASECType::query()->where('status', 1)->orderBy('type_name')->get()
            ->map(fn ($type) => $this->riasecAdminPayload($type))->all();
    }

    public function riasecAdminPayload(stp_RIASECType $type): array
    {
        $draft = $type->posterAssetSets()->where('status', 'draft')->latest()->first();
        $published = $type->posterAssetSets()->where('status', 'published')->latest('published_at')->first();

        return [
            'id' => $type->id,
            'type' => $type->type_name,
            'draft' => $this->riasecSetPayload($draft),
            'published' => $this->riasecSetPayload($published),
            'ready' => $published ? $this->riasecSetComplete($published) : false,
        ];
    }

    public function saveRiasecDraft(stp_RIASECType $type, array $data, ?UploadedFile $animal): stp_riasecPosterAssetSet
    {
        $published = $type->posterAssetSets()->where('status', 'published')->latest('published_at')->first();
        $draft = $type->posterAssetSets()->firstOrCreate(['status' => 'draft'], [
            'animal_name' => $published?->animal_name,
            'animal_source_path' => $published?->animal_source_path,
            'animal_image_path' => $published?->animal_image_path,
            'traits' => $published?->traits ?? $data['traits'],
            'accent_color' => $published?->accent_color ?? '#c71919',
        ]);
        $draft->fill(['animal_name' => $data['animal_name'], 'traits' => $data['traits'], 'accent_color' => $data['accent_color']]);
        if ($animal) {
            if (! $this->hasTransparency($animal)) {
                throw ValidationException::withMessages(['animal' => ['The animal image must contain a transparent background.']]);
            }
            $oldSource = $draft->animal_source_path;
            $oldRender = $draft->animal_image_path;
            [$source, $render] = $this->storeImage($animal, "riasec/".Str::slug($type->type_name), 'animal');
            $draft->animal_source_path = $source;
            $draft->animal_image_path = $render;
            $this->removeRiasecFilesWhenUnused($oldSource, $oldRender, $draft->id);
        }
        $draft->save();

        return $draft->fresh();
    }

    public function publishRiasec(stp_RIASECType $type, int $adminId): stp_riasecPosterAssetSet
    {
        return DB::transaction(function () use ($type, $adminId) {
            $draft = $type->posterAssetSets()->where('status', 'draft')->lockForUpdate()->first();
            if (! $draft || ! $this->riasecSetComplete($draft)) {
                throw ValidationException::withMessages(['assets' => ['Animal name, transparent image, three traits, and accent colour are required.']]);
            }
            $type->posterAssetSets()->where('status', 'published')->update(['status' => 'archived']);
            $draft->update(['status' => 'published', 'published_by' => $adminId, 'published_at' => now()]);

            return $draft->fresh();
        });
    }

    public function resolvePoster(string $topType, array $matches, string $token): array
    {
        if (! Schema::hasTable('stp_career_asset_sets') || ! Schema::hasTable('stp_riasec_poster_asset_sets')) {
            return ['version' => 'legacy', 'ready' => false];
        }

        $riasecType = stp_RIASECType::where('type_name', $topType)->first();
        $riasec = $riasecType?->posterAssetSets()->where('status', 'published')->latest('published_at')->first();
        if (! $riasec || ! $this->riasecSetComplete($riasec) || count($matches) < 3) {
            return ['version' => 'legacy', 'ready' => false];
        }

        $positions = ['left', 'center', 'right'];
        $resolved = [];
        $versions = [$riasec->updated_at?->timestamp ?? 0];
        foreach (array_slice($matches, 0, 3) as $index => $match) {
            $career = stp_career::find($match['career_id'] ?? null);
            $set = $career?->assetSets()->where('status', 'published')->latest('published_at')->first();
            if (! $set || ! $this->careerSetComplete($set)) {
                return ['version' => 'legacy', 'ready' => false];
            }
            $position = $positions[$index];
            $resolved[] = [
                'rank' => $index + 1,
                'career_id' => $career->id,
                'slug' => $career->slug,
                'name' => $match['name'] ?? $career->name,
                'match_percentage' => $match['match_percentage'] ?? null,
                'position' => $position,
                'image_url' => $this->publicUrl($set->getAttribute("{$position}_image_path")),
            ];
            $versions[] = $set->updated_at?->timestamp ?? 0;
        }
        $version = max($versions);

        return [
            'version' => 'career-v1',
            'ready' => true,
            'asset_version' => $version,
            'riasec' => [
                'type' => $topType,
                'animal_name' => $riasec->animal_name,
                'animal_url' => $this->publicUrl($riasec->animal_image_path),
                'traits' => $riasec->traits,
                'accent_color' => $riasec->accent_color,
            ],
            'career_matches' => $resolved,
            'og_image_url' => url("/api/student/riasecOgImage/{$token}")."?v={$version}",
        ];
    }

    private function storeImage(UploadedFile $file, string $directory, string $label): array
    {
        $id = Str::uuid()->toString();
        $sourceName = "{$label}-{$id}.".$file->getClientOriginalExtension();
        $sourcePath = $file->storeAs("poster-source/{$directory}", $sourceName, 'local');
        $renderPath = "poster-assets/{$directory}/{$label}-{$id}.webp";
        $manager = new ImageManager(new Driver);
        $encoded = $manager->read($file->getRealPath())->toWebp(88);
        $publicPath = public_path('storage/'.$renderPath);
        File::ensureDirectoryExists(dirname($publicPath));
        File::put($publicPath, (string) $encoded);

        return [$sourcePath, $renderPath];
    }

    private function hasTransparency(UploadedFile $file): bool
    {
        $mime = $file->getMimeType();
        $image = $mime === 'image/png' && function_exists('imagecreatefrompng')
            ? @imagecreatefrompng($file->getRealPath())
            : (($mime === 'image/webp' && function_exists('imagecreatefromwebp')) ? @imagecreatefromwebp($file->getRealPath()) : false);
        if (! $image) {
            return false;
        }
        $width = imagesx($image);
        $height = imagesy($image);
        $stepX = max(1, intdiv($width, 150));
        $stepY = max(1, intdiv($height, 150));
        for ($y = 0; $y < $height; $y += $stepY) {
            for ($x = 0; $x < $width; $x += $stepX) {
                if (((imagecolorat($image, $x, $y) >> 24) & 0x7F) > 0) {
                    imagedestroy($image);
                    return true;
                }
            }
        }
        imagedestroy($image);
        return false;
    }

    private function careerSetComplete(stp_careerAssetSet $set): bool
    {
        return collect(self::POSITIONS)->every(fn ($position) => filled($set->getAttribute("{$position}_image_path")));
    }

    private function riasecSetComplete(stp_riasecPosterAssetSet $set): bool
    {
        return filled($set->animal_name) && filled($set->animal_image_path)
            && is_array($set->traits) && count($set->traits) === 3
            && preg_match('/^#[0-9a-f]{6}$/i', $set->accent_color);
    }

    private function cloneCareerPaths(?stp_careerAssetSet $set): array
    {
        if (! $set) return [];
        $data = [];
        foreach (self::POSITIONS as $position) {
            $data["{$position}_source_path"] = $set->getAttribute("{$position}_source_path");
            $data["{$position}_image_path"] = $set->getAttribute("{$position}_image_path");
        }
        return $data;
    }

    private function careerSetPayload(?stp_careerAssetSet $set): ?array
    {
        if (! $set) return null;
        return ['id' => $set->id, 'status' => $set->status, 'left_url' => $this->publicUrl($set->left_image_path),
            'center_url' => $this->publicUrl($set->center_image_path), 'right_url' => $this->publicUrl($set->right_image_path),
            'complete' => $this->careerSetComplete($set), 'published_at' => $set->published_at];
    }

    private function riasecSetPayload(?stp_riasecPosterAssetSet $set): ?array
    {
        if (! $set) return null;
        return ['id' => $set->id, 'status' => $set->status, 'animal_name' => $set->animal_name,
            'animal_url' => $this->publicUrl($set->animal_image_path), 'traits' => $set->traits,
            'accent_color' => $set->accent_color, 'complete' => $this->riasecSetComplete($set), 'published_at' => $set->published_at];
    }

    private function publicUrl(?string $path): ?string
    {
        return $path ? url('/api/student/posterAsset/'.ltrim($path, '/')) : null;
    }

    private function removeCareerFilesWhenUnused(?string $source, ?string $render, int $exceptId): void
    {
        foreach (self::POSITIONS as $position) {
            if ($source && stp_careerAssetSet::where('id', '!=', $exceptId)->where("{$position}_source_path", $source)->exists()) {
                $source = null;
            }
            if ($render && stp_careerAssetSet::where('id', '!=', $exceptId)->where("{$position}_image_path", $render)->exists()) {
                $render = null;
            }
        }
        if ($source) Storage::disk('local')->delete($source);
        if ($render) File::delete(public_path('storage/'.$render));
    }

    private function removeRiasecFilesWhenUnused(?string $source, ?string $render, int $exceptId): void
    {
        if ($source && ! stp_riasecPosterAssetSet::where('id', '!=', $exceptId)->where('animal_source_path', $source)->exists()) {
            Storage::disk('local')->delete($source);
        }
        if ($render && ! stp_riasecPosterAssetSet::where('id', '!=', $exceptId)->where('animal_image_path', $render)->exists()) {
            File::delete(public_path('storage/'.$render));
        }
    }
}
