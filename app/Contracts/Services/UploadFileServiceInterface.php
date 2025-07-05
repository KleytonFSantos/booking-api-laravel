<?php

namespace App\Contracts\Services;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

interface UploadFileServiceInterface
{
    public function create(?UploadedFile $file): ?string;
    public function override(?UploadedFile $file): ?string;
    public function delete(?UploadedFile $file): void;
    public function getFile(FormRequest $request): ?UploadedFile;
}
