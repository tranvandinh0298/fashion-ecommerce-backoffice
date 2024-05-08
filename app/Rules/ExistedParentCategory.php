<?php

namespace App\Rules;

use App\Services\CategoryService;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Log;

class ExistedParentCategory implements Rule
{
    protected $categoryService;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->categoryService = new CategoryService();
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return !empty($this->categoryService->getCategoryById($value));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This parent category is invalid';
    }
}
