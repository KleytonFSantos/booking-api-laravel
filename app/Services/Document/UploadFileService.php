<?php

namespace App\Services\Document;

use Illuminate\Http\UploadedFile;

class UploadFileService implements UploadFileInterface
{
    const PATH = 'C:\Users\aninh\OneDrive\Documentos\teste';

    public function create(UploadedFile $file): string
    {
        if ($file->isValid()) {
            $file->move(
                self::PATH,
                $file->getClientOriginalName()
            );
        }

        return self::PATH . "\\" . $file->getClientOriginalName();
    }

    public function override(UploadedFile $file): string
    {
        return '';
    }

    public function delete(UploadedFile $file): void
    {

    }
}
