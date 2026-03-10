<?php

namespace App\Modules\Ticket\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "CreateTicketRequest",
    title: "Create Ticket Request",
    required: ["name", "phone", "email", "subject", "text"],
    properties: [
        new OA\Property(property: "name", type: "string", example: "Куанышбек Мыкыев"),
        new OA\Property(property: "phone", type: "string", example: "+79654444444"),
        new OA\Property(property: "email", type: "string", format: "email", example: "kuan@example.com"),
        new OA\Property(property: "subject", type: "string", example: "Проблема с оплатой"),
        new OA\Property(property: "text", type: "string", example: "Не могу оплатить заказ через сайт"),
    ]
)]
class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [

        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [

        ];
    }
}
