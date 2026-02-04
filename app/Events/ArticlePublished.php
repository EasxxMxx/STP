<?php

namespace App\Events;

use App\Models\stp_article;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ArticlePublished
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $article;

    /**
     * Create a new event instance.
     */
    public function __construct(stp_article $article)
    {
        $this->article = $article;
    }
}
