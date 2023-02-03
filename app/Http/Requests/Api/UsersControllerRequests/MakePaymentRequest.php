<?php

namespace App\Http\Requests\Api\UsersControllerRequests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class MakePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape([
        'sum' => "string"
    ])]
    public function rules(): array
    {
        return [
            'sum' => 'required|integer'
        ];
    }
}
