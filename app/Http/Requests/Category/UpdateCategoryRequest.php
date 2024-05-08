<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'summary' => 'string|nullable',
            'photo' => 'string|nullable',
            'status' => 'required|in:active,inactive',
            'isParent' => 'sometimes|in:1',
            'parentCategoryId' => 'nullable|exists:categories,id',
        ];
    }

        /**
     * Handle request before validation
     * 
     * @return void
     */
    public function prepareForValidation(): void
    {
        $photo = parse_url($this->photo)['path'];

        $this->merge([
            'photo' => $photo
        ]);
    }
}
