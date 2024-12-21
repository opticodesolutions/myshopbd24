<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class RunQueueWorker implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public function __construct()
    {
        // You can pass any parameters you need to the job constructor
    }

    public function handle()
    {
        try {
            // Start queue worker
            Artisan::call('queue:work', [
                '--stop-when-empty' => true,
            ]);
        } catch (\Exception $e) {
            Log::error('Error processing job queue: ' . $e->getMessage());
        }
    }
}
