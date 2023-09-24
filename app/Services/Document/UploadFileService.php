<?php

namespace App\Services\Document;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

class UploadFileService implements UploadFileInterface
{
    const PATH = 'C:\Users\aninh\OneDrive\Documentos\teste';

    public function create(?UploadedFile $file): ?string
    {
        if (!$file) {
            return null;
        }

        if ($file->isValid()) {
            $file->move(
                self::PATH,
                $file->getClientOriginalName()
            );
        }

        return self::PATH . "\\" . $file->getClientOriginalName();
    }

    public function override(?UploadedFile $file): ?string
    {
        return '';
    }

    public function delete(?UploadedFile $file): void
    {

    }

    public function getFileName(FormRequest $request): ?UploadedFile
    {
        $hasFile = $request->hasFile('document');

        if ($hasFile) {
            return $request->file('document');
        }

        return null;    }
}
