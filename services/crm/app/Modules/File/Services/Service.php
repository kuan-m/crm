<?php

namespace App\Modules\File\Services;

use App\Modules\File\Contracts\IFileRepository;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Service
{
    public function __construct(
        protected IFileRepository $repo,
    ) {}

    /**
     * @param  UploadedFile[]  $files
     * @return Media[]
     */
    public function attach(\Spatie\MediaLibrary\HasMedia $model, array $files, string $collection = 'attachments'): array
    {
        return $this->repo->attach($model, $files, $collection);
    }
}
