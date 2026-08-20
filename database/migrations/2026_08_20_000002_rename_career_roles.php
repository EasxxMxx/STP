<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('stp_careers')) {
            return;
        }

        // Move Programmer first so Developer can take its student-facing name.
        $this->renameCareer('programmer', 'Statistician', [25, 100, 25, 35, 30, 95]);
        $this->renameCareer('developer', 'Programmer', [50, 95, 55, 30, 35, 90]);
        $this->renameCareer('physiotherapist', 'Physio', [70, 75, 30, 95, 35, 55]);
        $this->renameCareer('surveyor', 'Mechanic', [95, 65, 25, 30, 40, 90]);
        $this->renameCareer('analyst', 'Economist', [25, 95, 35, 55, 85, 80]);
        $this->renameCareer('marketer', 'Publicist', [25, 55, 90, 80, 95, 50]);
        $this->renameCareer('recruiter', 'Diplomat', [25, 75, 55, 95, 95, 65]);
    }

    public function down(): void
    {
        if (! Schema::hasTable('stp_careers')) {
            return;
        }

        // Free Programmer before restoring Statistician to the former role.
        $this->renameCareer('programmer', 'Developer', [55, 90, 80, 30, 45, 70]);
        $this->renameCareer('statistician', 'Programmer', [55, 95, 55, 30, 35, 90]);
        $this->renameCareer('physio', 'Physiotherapist', [70, 75, 30, 95, 35, 55]);
        $this->renameCareer('mechanic', 'Surveyor', [85, 75, 30, 35, 55, 90]);
        $this->renameCareer('economist', 'Analyst', [35, 95, 30, 45, 80, 85]);
        $this->renameCareer('publicist', 'Marketer', [25, 55, 90, 70, 95, 55]);
        $this->renameCareer('diplomat', 'Recruiter', [25, 55, 50, 95, 90, 70]);
    }

    private function renameCareer(string $currentSlug, string $newName, array $profile): void
    {
        DB::table('stp_careers')
            ->where('slug', $currentSlug)
            ->update([
                'slug' => str($newName)->slug()->toString(),
                'name' => $newName,
                'realistic' => $profile[0],
                'investigative' => $profile[1],
                'artistic' => $profile[2],
                'social' => $profile[3],
                'enterprising' => $profile[4],
                'conventional' => $profile[5],
                'updated_at' => now(),
            ]);
    }
};
