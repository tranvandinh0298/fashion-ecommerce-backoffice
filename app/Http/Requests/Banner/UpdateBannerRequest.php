<?php

namespace App\Http\Requests\Banner;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBannerRequest extends FormRequest
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
            'title' => 'string|required|max:50',
            'description' => 'string|nullable',
            'photo' => 'string|required',
            'status' => 'required|in:active,inactive',
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
            'photo' => $photo,
        ]);
    }
}
