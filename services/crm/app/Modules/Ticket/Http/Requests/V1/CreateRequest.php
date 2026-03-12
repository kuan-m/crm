<?php

namespace App\Modules\Ticket\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'CreateTicketRequest',
    title: 'Create Ticket Request',
    required: ['name', 'phone', 'email', 'subject', 'text'],
    properties: [
        new OA\Property(property: 'name', type: 'string', example: 'Куанышбек Мыкыев'),
        new OA\Property(property: 'phone', type: 'string', example: '+79654444444'),
        new OA\Property(property: 'email', type: 'string', format: 'email', example: 'kuan@example.com'),
        new OA\Property(property: 'subject', type: 'string', example: 'Проблема с оплатой'),
        new OA\Property(property: 'text', type: 'string', example: 'Не могу оплатить заказ через сайт'),
    ]
)]
class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'phone:AUTO'],
            'email' => ['required', 'email:rfc,dns', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'text' => ['required', 'string', 'max:5000'],
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
            'name.required' => 'Имя обязательно для заполнения.',
            'name.max' => 'Имя не должно превышать 255 символов.',
            'phone.required' => 'Номер телефона обязателен.',
            'phone.phone' => 'Введите корректный номер телефона в международном формате.',
            'email.required' => 'Электронная почта обязательна.',
            'email.email' => 'Введите корректный адрес электронной почты.',
            'subject.required' => 'Укажите тему заявки.',
            'subject.max' => 'Тема не должна превышать 255 символов.',
            'text.required' => 'Текст заявки обязателен.',
            'text.max' => 'Текст заявки не должен превышать 5000 символов.',
        ];
    }
}
