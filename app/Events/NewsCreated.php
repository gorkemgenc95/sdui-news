<?php

namespace App\Events;

use App\Models\News;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewsCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public News $news;

    public function __construct($news)
    {
        $this->news = $news;
    }
}
