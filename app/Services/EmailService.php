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
        if (!File::exists($emlPath)) {
            $emlPath = Storage::path('public') . '/' . $emlPath;
        }

        $emlContents = File::get($emlPath);

        $this->parser->setText($emlContents);

        $data['sender_address'] = $this->parser->getHeader('from');
        $data['recipient_address'] = $this->parser->getHeader('to');
        $data['subject'] = $this->parser->getHeader('subject');
        $data['body'] = $this->parser->getMessageBody('text') ?: null;

        $storagePath = self::ARCHIVE_DIR . basename($emlPath);
        $data['eml_location'] = $storagePath;

        Storage::put($storagePath, $emlContents);

        return Email::create($data);
    }
}
