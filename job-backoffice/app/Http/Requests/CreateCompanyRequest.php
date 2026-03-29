<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:companies,name',
            'address' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'website' => 'nullable|string|url|max:255',
        ];
    }
    public function messages() {
        return [
            'name.required' => 'The company name is required',
            'name.unique' => 'The company name has already been taken',
            'name.string' => 'The company name must be a string',
            'name.max' => 'The company name must be less than 255 characters',
            'address.required' => 'The company address is required',
            'address.string' => 'The company address must be a string',
            'address.max' => 'The company address must be less than 255 characters',
            'industry.required' => 'The company industry is required',
            'industry.string' => 'The company industry must be a string',
            'industry.max' => 'The company industry must be less than 255 characters',
            'website.url' => 'The company website must be a valid URL ',
            'website.string' => 'The company website must be a string',
            'website.max' => 'The company website must be less than 255 characters',
        ];
    }
}
