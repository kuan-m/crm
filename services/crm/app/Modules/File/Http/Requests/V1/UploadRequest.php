<?php

namespace App\Modules\File\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'UploadFileRequest',
    type: 'object',
    required: ['files'],
    properties: [
        new OA\Property(
            property: 'files[]',
            description: 'Массив загружаемых файлов',
            type: 'array',
            items: new OA\Items(type: 'string', format: 'binary')
        ),
    ]
)]
class UploadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'files' => ['required', 'array', 'min:1', 'max:5'],
            'files.*' => ['required', 'file', 'max:10240', 'mimes:jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx,zip'],
        ];
    }

    public function messages(): array
    {
        return [
            'files.required' => 'Необходимо прикрепить хотя бы один файл.',
            'files.array' => 'Файлы должны быть переданы массивом.',
            'files.min' => 'Необходимо прикрепить хотя бы один файл.',
            'files.max' => 'Можно прикрепить не более 5 файлов.',
            'files.*.required' => 'Файл обязателен.',
            'files.*.file' => 'Загружаемый элемент должен быть файлом.',
            'files.*.max' => 'Размер файла не должен превышать 10 МБ.',
            'files.*.mimes' => 'Допустимые форматы: jpg, jpeg, png, gif, pdf, doc, docx, xls, xlsx, zip.',
        ];
    }
}
