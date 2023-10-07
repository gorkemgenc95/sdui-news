<?php

namespace App\Listeners;

use App\Events\NewsCreated;
use Illuminate\Support\Facades\Log;

class NewsCreatedListener
{
    public function handle(NewsCreated $event): void
    {
        $news = $event->news;
        Log::info("News Created: Title - {$news->title}, Content - {$news->content}");
    }
}
