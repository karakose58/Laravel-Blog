<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Post;

class start_stop extends Command
{
    protected $signature = 'posts:start_stop';
    protected $description = 'Start tarihi gelmiş olanları aktif, stop tarihi geçmiş olanları pasif yapar.';

    public function handle()
    {
        $now = Carbon::now();

        $activatedCount = Post::where('start', '<=', $now)
            ->where('status', 0)
            ->update(['status' => 1]);

        $deactivatedCount = Post::where('stop', '<=', $now)
            ->where('status', 1)
            ->update(['status' => 0]);

        $this->info("Aktif hale getirilen yazı sayısı: $activatedCount");
        $this->info("Pasif hale getirilen yazı sayısı: $deactivatedCount");
    }
}
