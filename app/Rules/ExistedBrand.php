<?php

namespace App\Rules;

use App\Services\BrandService;
use Illuminate\Contracts\Validation\Rule;

class ExistedBrand implements Rule
{
    protected $brandService;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->brandService = new BrandService();
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
        return !empty($this->brandService->getBrandById($value));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
