<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsletterSentLog extends Model
{
    use HasFactory;

    protected $table = 'newsletter_sent';

    protected $fillable = [
        'newsletter_subscription_id',
        'email',
        'article_count',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'article_count' => 'integer',
    ];

    /**
     * Get the subscription that this log belongs to
     */
    public function subscription()
    {
        return $this->belongsTo(NewsletterSubscription::class, 'newsletter_subscription_id');
    }
}
