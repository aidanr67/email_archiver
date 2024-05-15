<?php

namespace App\Services;

use App\Models\Email;
use Exception;
use eXorus\PhpMimeMailParser\Parser;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class EmailService
{
    const ARCHIVE_DIR = 'archive/emls/';

    private Parser $parser;

    /**
     * @param Parser $parser
     */
    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Parse and save a .eml file.
     *
     * @param string $emlPath
     *
     * @return Email
     *
     * @throws Exception
     * @throws FileNotFoundException
     */
    public function parseAndSaveEml(string $emlPath): Email
    {
        $emlContents = File::get($emlPath);

        $this->parser->setText($emlContents);

        $data['sender_address'] = $this->parser->getHeader('from') ?: null;
        $data['recipient_address'] = $this->parser->getHeader('to') ?: null;
        $data['subject'] = $this->parser->getHeader('subject') ?: null;
        $data['body_plain'] = $this->parser->getMessageBody('text') ?: null;
        $data['body'] = $this->parser->getMessageBody('html') ?: null;
        $data['attachments'] = $this->parser->getAttachments() ?: null;

        $storagePath = self::ARCHIVE_DIR . basename($emlPath);
        $data['eml_location'] = $storagePath;

        Storage::put($storagePath, $emlContents);

        return Email::create($data);
    }

    /**
     * Appends a new tag to tag array.
     *
     * @param Email $email
     * @param string $tag
     *
     * @return void
     */
    public function addTag(Email $email, string $tag): void
    {
        $tags = $email->tags;
        $tags[] = $tag;
        $email->tags = $tags;

        $email->save();
    }
}
