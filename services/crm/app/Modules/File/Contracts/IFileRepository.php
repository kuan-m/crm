<?php

namespace App\Modules\File\Contracts;

use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

interface IFileRepository
{
    /**
     * @param  UploadedFile[]  $files
     * @return Media[]
     */
    public function attach(HasMedia $model, array $files, string $collection = 'attachments'): array;
}
