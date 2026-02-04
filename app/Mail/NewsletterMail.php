<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\stp_article;
use App\Models\stp_intake;
use App\Models\stp_core_meta;
use Carbon\Carbon;

class NewsletterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $sendDate;
    public $latestArticle;
    public $intakes;
    public $recommendedArticles;
    public $articlesListUrl;
    public $unsubscribeUrl;
    public $facebookUrl;
    public $instagramUrl;
    public $websiteUrl;

    /**
     * Create a new message instance.
     * Month-based logic uses $sendDate.
     *
     * @param Carbon|string|null $sendDate Edition date (default: now())
     * @param string|null $articlesListUrl Default https://studypal.my/articles
     * @param string|null $unsubscribeUrl
     * @param string|null $facebookUrl
     * @param string|null $instagramUrl
     * @param string|null $websiteUrl
     */
    public function __construct(
        $sendDate = null,
        ?string $articlesListUrl = null,
        ?string $unsubscribeUrl = null,
        ?string $facebookUrl = null,
        ?string $instagramUrl = null,
        ?string $websiteUrl = null
    ) {
        $this->sendDate = $sendDate ? Carbon::parse($sendDate) : now();
        $this->articlesListUrl = $articlesListUrl ?? 'https://studypal.my/articles';
        $this->unsubscribeUrl = $unsubscribeUrl;
        $this->facebookUrl = $facebookUrl ?? 'https://www.facebook.com/studypal.my';
        $this->instagramUrl = $instagramUrl ?? 'https://www.instagram.com/studypal.my';
        $this->websiteUrl = $websiteUrl ?? 'https://studypal.my';

        $baseStorageUrl = rtrim(config('app.url'), '/');
        if (str_contains($baseStorageUrl, 'localhost') || str_contains($baseStorageUrl, '127.0.0.1')) {
            $baseStorageUrl = 'https://backendstudypal.studypal.my';
        }

        // A) Latest Article (ONLY 1) – with category for email display
        $latestModel = stp_article::where('data_status', 1)
            ->with('category')
            ->orderBy('article_date', 'desc')
            ->orderBy('id', 'desc')
            ->first();

        $this->latestArticle = $latestModel ? $this->formatArticle($latestModel, $baseStorageUrl) : null;

        // B) Upcoming Intakes (MAX 5) – which universities have intake in that month (one card per uni, not per course)
        $monthName = $this->sendDate->format('F');
        $monthMeta = stp_core_meta::where('core_metaName', $monthName)->first();
        $intakeModels = collect();
        if ($monthMeta) {
            $intakeModels = stp_intake::where('intake_month', $monthMeta->id)
                ->with(['course.school', 'month'])
                ->orderBy('id', 'asc')
                ->get();
        }
        $frontendBase = 'https://studypal.my';
        $intakeMonthParam = $this->sendDate->format('Y-m');

        // Group by university (school_id), take up to 5 unique universities
        $bySchool = $intakeModels->filter(fn ($i) => $i->course && $i->course->school)
            ->groupBy(fn ($i) => $i->course->school_id)
            ->take(5);

        $this->intakes = $bySchool->map(function ($intakesForSchool) use ($baseStorageUrl, $frontendBase, $intakeMonthParam) {
            $first = $intakesForSchool->first();
            $course = $first->course;
            $school = $course->school;
            $logo = null;
            if ($school && isset($school->school_logo) && $school->school_logo) {
                $logo = filter_var($school->school_logo, FILTER_VALIDATE_URL)
                    ? $school->school_logo
                    : $baseStorageUrl . '/storage/' . ltrim($school->school_logo, '/');
            }
            if (!$logo && $course->course_logo) {
                $logo = filter_var($course->course_logo, FILTER_VALIDATE_URL)
                    ? $course->course_logo
                    : $baseStorageUrl . '/storage/' . ltrim($course->course_logo, '/');
            }
            $universityName = $school->school_name ?? 'University';
            $monthLabel = $first->month ? $first->month->core_metaName : $this->sendDate->format('F');
            $intakeInfo = $monthLabel . ' Intake';

            $link = $frontendBase . '/institute?school_id=' . $school->id . '&intake_month=' . $intakeMonthParam;

            return [
                'logo_url' => $logo,
                'university_name' => $universityName,
                'intake_info' => $intakeInfo,
                'link' => $link,
            ];
        })->values()->all();

        // C) Recommended Reads (5) – exclude latestArticle at query level
        $recommendedModels = stp_article::where('data_status', 1)
            ->when($latestModel, fn ($q) => $q->where('id', '!=', $latestModel->id))
            ->orderBy('article_date', 'desc')
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        $this->recommendedArticles = $recommendedModels->map(function ($article) use ($baseStorageUrl) {
            $arr = $this->formatArticle($article, $baseStorageUrl);
            return [
                'title' => $arr['title'],
                'author' => $arr['author'] ?? '',
                'link' => $arr['link'],
            ];
        })->values()->all();
    }

    /**
     * Format a single article for email (image, title, excerpt, author, link).
     */
    private function formatArticle(stp_article $article, string $baseStorageUrl): array
    {
        $image = null;
        if ($article->article_featured_image) {
            $image = filter_var($article->article_featured_image, FILTER_VALIDATE_URL)
                ? $article->article_featured_image
                : $baseStorageUrl . '/storage/' . ltrim($article->article_featured_image, '/');
        }

        $excerpt = null;
        $raw = $article->article_summary ?? $article->article_main_points_1 ?? '';
        if ($raw) {
            $plain = preg_replace('/\s+/', ' ', trim(strip_tags($raw)));
            $excerpt = strlen($plain) > 160 ? substr($plain, 0, 160) . '...' : $plain;
        }
        if (!$excerpt && $article->article_content && file_exists(public_path('storage/' . $article->article_content))) {
            $html = @file_get_contents(public_path('storage/' . $article->article_content));
            if ($html !== false) {
                $plain = preg_replace('/\s+/', ' ', trim(strip_tags($html)));
                $excerpt = strlen($plain) > 160 ? substr($plain, 0, 160) . '...' : $plain;
            }
        }

        $link = 'https://studypal.my/articles/read/' . $article->id;
        $author = $article->article_author ?? '';
        $categoryName = $article->category ? $article->category->category_name : null;
        $categoryLink = 'https://studypal.my/articles';

        return [
            'id' => $article->id,
            'title' => $article->article_title,
            'image' => $image,
            'excerpt' => $excerpt,
            'author' => $author,
            'category' => $categoryName,
            'category_link' => $categoryLink,
            'link' => $link,
        ];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $monthYear = $this->sendDate->format('F Y');
        return new Envelope(
            subject: "StudyPal Newsletter – {$monthYear}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.newsletter',
            with: [
                'sendDate' => $this->sendDate,
                'latestArticle' => $this->latestArticle,
                'intakes' => $this->intakes,
                'recommendedArticles' => $this->recommendedArticles,
                'articlesListUrl' => $this->articlesListUrl,
                'unsubscribeUrl' => $this->unsubscribeUrl,
                'facebookUrl' => $this->facebookUrl,
                'instagramUrl' => $this->instagramUrl,
                'websiteUrl' => $this->websiteUrl,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
