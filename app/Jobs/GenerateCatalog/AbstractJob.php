<?php

namespace App\Jobs\GenerateCatalog;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AbstractJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        $this->onQueue('generate-catalog'); // Черга за замовчуванням
    }

    public function handle()
    {
        $this->debug('done');
    }

    protected function debug(string $msg)
    {
        $class = static::class;
        $msg = $msg . " [{$class}]";
        Log::info($msg);
    }
}
