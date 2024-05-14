<?php
namespace Integration\Http\Controllers\API;

use App\Jobs\AddEmail;
use App\Support\Facades\EmailServiceFacade;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

/**
 * Class EmailControllerTest
 *
 * @package Tests\Integration\Http\Controllers
 *
 * @coversDefaultClass \App\Http\Controllers\API\EmailController
 *
 * @small
 */
class EmailControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the job is pushed to the queue and the appropriate result is returned.
     *
     * @test
     */
    public function testJobIsPushedAndCreatedStatusReturned()
    {
        $file = UploadedFile::fake()->create('test.eml');

        Queue::fake();

        $response = $this->postJson('api/email', ['eml_file' => $file]);

        Queue::assertPushed(AddEmail::class);

        // Assert the response
        $response->assertStatus(201)
            ->assertJson(['message' => 'File uploaded successfully']);
    }

    /**
     * Test that the appropriate error and status are returned when the eml file is not provided.
     *
     * @test
     */
    public function testValidationErrorAndStatusForEmlFile()
    {
        $response = $this->postJson('api/email');

        // Assert the response
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['eml_file']);
    }

    /**
     * Asserts that an exception in the service is bubbled up to the controller to be reported to the user.
     *
     * @return void
     */
    public function testServiceExceptionIsBubbledUp()
    {
        $file = UploadedFile::fake()->create('test.eml');

        EmailServiceFacade::shouldReceive('parseAndSaveEml')
            ->withArgs([$file])
            ->andThrow(\Exception::class);

        $response = $this->postJson('api/email', ['eml_file' => $file]);

        $this->assertEquals(500, $response->getStatusCode());

    }
}
