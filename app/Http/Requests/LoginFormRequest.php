<?php

namespace App\Http\Requests;

use App\Exceptions\ValidationException;
use App\Http\Requests\Abstractions\BaseFormRequest;
use Illuminate\Contracts\Validation\Validator;

/**
 * Class LoginFormRequest
 * @package App\Http\Requests
 */
class LoginFormRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string|min:10',
        ];
    }
}
