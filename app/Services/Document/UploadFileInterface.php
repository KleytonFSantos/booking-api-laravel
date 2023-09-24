<?php

namespace App\Services\Document;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

interface UploadFileInterface
{
    public function create(?UploadedFile $file): ?string;
    public function override(?UploadedFile $file): ?string;
    public function delete(?UploadedFile $file): void;

    public function getFileName(FormRequest $request): ?UploadedFile;

}
