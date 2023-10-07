<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\News;
use Carbon\Carbon;

class DeleteOldNews extends Command
{
    protected $signature = 'news:delete-old';
    protected $description = 'Delete news entries older than 14 days';

    public function handle()
    {
        $cutoffDate = Carbon::now()->subDays(14);
        News::query()->where('created_at', '<', $cutoffDate)->delete();
    }
}
