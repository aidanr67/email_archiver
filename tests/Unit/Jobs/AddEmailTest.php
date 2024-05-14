<?php

namespace Tests\Unit\Jobs;

use App\Jobs\AddEmail;
use App\Models\Email;
use App\Support\Facades\EmailServiceFacade;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

/**
 * Class AddEmailTest
 *
 * @package Tests\Unit\Jobs
 *
 * @small
 */
class AddEmailTest extends TestCase
{
    /**
     * Test that AddEmail jobs can be pushed to the queue and call the relevant service method.
     *
     * @return void
     */
    public function testJobIsPushedToQueue()
    {
        Queue::fake();
        Queue::assertNothingPushed();
        $emlPath = '/path/to/your/eml/file.eml';
        EmailServiceFacade::shouldReceive('parseAndSaveEml')
            ->withArgs([$emlPath])
            ->andReturn(Email::make([]));

        AddEmail::dispatch($emlPath);

        Queue::assertPushed(AddEmail::class);
    }
}
