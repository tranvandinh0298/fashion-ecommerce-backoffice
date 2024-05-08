<?php

namespace App\Http\Requests\Category;

use App\Rules\ExistedParentCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreCategoryRequest extends FormRequest
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
            'summary' => 'string|nullable',
            'photo' => 'string|nullable',
            'status' => 'required|in:active,inactive',
            'isParent' => 'sometimes|in:1',
            'parentCategoryId' => ['nullable', new ExistedParentCategory],
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

        $photo = parse_url($this->photo)['path'];

        $this->merge([
            'slug' => $slug,
            'photo' => $photo
        ]);
    }
}
