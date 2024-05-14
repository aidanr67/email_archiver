<?php

namespace Tests\Integration\Services;

use App\Services\EmailService;
use eXorus\PhpMimeMailParser\Parser;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Class EmailServiceTest
 *
 * @package Tests\Integration\Services
 *
 * @covers App\Services\EmailService
 *
 * @small
 */
class EmailServiceTest extends TestCase
{
    use RefreshDatabase;

    private EmailService $service;

    protected function setUp(): void
    {
        $this->service = new EmailService(new Parser());
        parent::setUp();
    }

    /**
     * Test that eml file is parsed correctly and saved.
     *
     * @return void
     */
    public function testParseAndSaveEml()
    {
        $emlFilePath = base_path('tests/files/basic_sample.eml');
        $storagePath = EmailService::ARCHIVE_DIR . basename($emlFilePath);
        $this->assertTrue(file_exists($emlFilePath), 'Sample .eml file does not exist.');

        Storage::shouldReceive('put')->withArgs([$storagePath, File::get($emlFilePath)])
            ->andReturn(true);
        // Call function we're testing.
        $resultantEmail = $this->service->parseAndSaveEml($emlFilePath);

        $this->assertTrue($resultantEmail->exists);

        // Assert that the email record is saved in the database
        $this->assertDatabaseHas('emails', [
            'sender_address' => 'sender@example.com',
            'recipient_address' => 'recipient@example.com',
            'subject' => 'Test Email',
            'body' => "This is a test email message.\n\nRegards,\nSender\n",
            'eml_location' => $storagePath,
        ]);
    }

    /**
     * Test that it can handle names of files in public directory.
     *
     * @return void
     */
    public function testPublicFileParseAndSaveEml()
    {
        $emlFilePath = 'basic_sample.eml';
        Storage::shouldReceive('path')
            ->withArgs(['public'])
            ->andReturn(base_path('tests/files/'));
        $storagePath = EmailService::ARCHIVE_DIR . basename($emlFilePath);

        Storage::shouldReceive('put')->withArgs([$storagePath, File::get(base_path('tests/files/') . '/' . $emlFilePath)])
            ->andReturn(true);
        // Call function we're testing.
        $resultantEmail = $this->service->parseAndSaveEml($emlFilePath);

        $this->assertTrue($resultantEmail->exists);

        // Assert that the email record is saved in the database
        $this->assertDatabaseHas('emails', [
            'sender_address' => 'sender@example.com',
            'recipient_address' => 'recipient@example.com',
            'subject' => 'Test Email',
            'body' => "This is a test email message.\n\nRegards,\nSender\n",
            'eml_location' => $storagePath,
        ]);
    }

    /**
     * Test that empty eml file is handled correctly.
     *
     * @return void
     */
    public function testEmptyEmlFile()
    {
        $emlFilePath = base_path('tests/files/empty_sample.eml');
        $storagePath = EmailService::ARCHIVE_DIR . basename($emlFilePath);
        $this->assertTrue(file_exists($emlFilePath), 'Sample .eml file does not exist.');

        Storage::shouldReceive('put')->withArgs([$storagePath, File::get($emlFilePath)])
            ->andReturn(true);

        // Should throw exception as values cannot be null.
        $this->expectException(\Exception::class);

        // Call function we're testing.
        $this->service->parseAndSaveEml($emlFilePath);
    }

    /**
     * Test file does not exist case.
     *
     * @return void
     * @throws \Exception
     */
    public function testFileDoesNotExist()
    {
        $emlFilePath = base_path('tests/files/no_file_sample.eml');
        $this->assertFalse(file_exists($emlFilePath));

        $this->expectException(FileNotFoundException::class);
        // Call function we're testing.
        $this->service->parseAndSaveEml($emlFilePath);
    }
}
