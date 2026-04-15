<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ApplyJobRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'resume_file' => 'required|file|mimes:pdf|max:5120',
        ];
    }
    public function messages() {
        return [
            'resume_file.required' => 'The resume file is required',
            'resume_file.file' => 'The resume file must be a file',
            'resume_file.max' =>  'The resume file must be less than 5MB',
        ];
    }
}
