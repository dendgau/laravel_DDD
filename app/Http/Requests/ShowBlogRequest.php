<?php

namespace App\Http\Requests;

use Domain\Contracts\Services\BlogServiceContract;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ShowBlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /** @var BlogServiceContract $blogService */
        $blogService = app(BlogServiceContract::class);

        $blog = $blogService->getBlog($this->id);
        return Auth::user()->can('view', $blog);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}
