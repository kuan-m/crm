<?php

namespace App\Modules\File\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

interface IFileRepository
{
    /**
     * @param  UploadedFile[]  $files
     * @return Media[]
     */
    public function attach(Model $model, array $files, string $collection = 'attachments'): array;
}
