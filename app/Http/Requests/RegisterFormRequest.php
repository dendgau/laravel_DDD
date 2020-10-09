<?php

namespace App\Http\Requests;

use App\Http\Requests\Abstractions\BaseFormRequest;

/**
 * Class RegisterFormRequest
 * @package App\Http\Requests
 */
class RegisterFormRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ];
    }
}
