<?php

namespace App\Http\Requests\Product;

use App\Rules\ExistedBrand;
use App\Rules\ExistedParentCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdateProductRequest extends FormRequest
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
            'summary' => 'string|required',
            'description' => 'string|nullable',
            'photo' => 'string|required',
            'size' => 'nullable',
            'stock' => "required|numeric",
            'categoryId' => ['required', new ExistedParentCategory],
            'brandId' => ['nullable', new ExistedBrand],
            'childCategoryId' => ['nullable', new ExistedParentCategory],
            'isFeatured' => 'sometimes|in:1',
            'status' => 'required|in:active,inactive',
            'condition' => 'required|in:default,new,hot',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric'
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
            'photo' => $photo,
            'isFeatured' => !empty($this->isFeatured) ? $this->isFeatured : 0,
            'size' => !empty($this->size) ? implode(',', $this->size) : '',
        ]);
    }
}
