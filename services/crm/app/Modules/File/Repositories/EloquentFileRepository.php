<?php

namespace App\Modules\File\Repositories;

use App\Modules\File\Contracts\IFileRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class EloquentFileRepository implements IFileRepository
{
    /**
     * @param  UploadedFile[]  $files
     * @return Media[]
     */
    public function attach(Model $model, array $files, string $collection = 'attachments'): array
    {
        $media = [];

        foreach ($files as $file) {
            $media[] = $model
                ->addMedia($file)
                ->usingFileName(Str::random(10).'.'.$file->getClientOriginalExtension())
                ->toMediaCollection($collection);
        }

        return $media;
    }
}
