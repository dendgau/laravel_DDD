<?php

namespace App\Http\Requests\Abstractions;

use App\Exceptions\BusinessException;
use App\Exceptions\ValidationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

/**
 * Class BaseFormRequest
 * @package App\Http\Requests
 */
class BaseFormRequest extends FormRequest
{
    /**
     * @param Validator $validator
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator);
    }
}
