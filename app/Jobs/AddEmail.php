<?php

namespace App\Jobs;

use App\Support\Facades\EmailServiceFacade;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Class AddEmail
 *
 * @package App\Jobs
 */
class AddEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $emlPath;

    /**
     * Create a new job instance.
     *
     * @param string $emlPath The path to the .eml file.
     *
     * @return void
     */
    public function __construct(string $emlPath)
    {
        $this->emlPath = $emlPath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        EmailServiceFacade::parseAndSaveEml($this->emlPath);
    }
}
