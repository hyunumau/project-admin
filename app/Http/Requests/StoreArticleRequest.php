<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
{
    /**
     * Determine if the article is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'caption' => ['required'],
            'detail' => ['required'],
            'image' => ['required', 'file', 'max:512'],
            'categories' => ['nullable'],
            'tags' => ['nullable'],
        ];
    }
}
