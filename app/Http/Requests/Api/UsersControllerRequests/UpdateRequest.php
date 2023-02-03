<?php

namespace App\Http\Requests\Api\UsersControllerRequests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class UpdateRequest extends FormRequest
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
        'name' => "string",
        'email' => "string",
        'phone' => "string"
    ])]
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($this->route('id'))],
            'phone' => ['required', 'integer', 'digits_between:7,10', Rule::unique('users')->ignore($this->route('id'))],
        ];
    }
}
