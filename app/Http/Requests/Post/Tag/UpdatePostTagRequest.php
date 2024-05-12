<?php

namespace App\Http\Requests\Post\Tag;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdatePostTagRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'string|required',
            'slug' => 'string|required',
            'status' => 'required|in:active,inactive'
        ];
    }

    /**
     * Handle request before validation
     * 
     * @return void
     */
    public function prepareForValidation(): void
    {
        $slug = Str::slug($this->title) . '-' . date('ymdis') . '-' . rand(0, 999);

        $this->merge([
            'slug' => $slug,
        ]);
    }
}
