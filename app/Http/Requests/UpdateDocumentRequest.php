<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDocumentRequest extends FormRequest
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
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'category_id' => ['sometimes', 'required', 'exists:categories,id'],
            'is_public' => ['boolean'],
            'document' => [
                'sometimes',
                'required',
                'file',
                'max:10240', // 10MB
                'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx'
            ],
            'tags' => ['array'],
            'tags.*' => ['exists:tags,id']
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'document.max' => 'Ukuran file tidak boleh lebih dari 10MB',
            'document.mimes' => 'Format file harus PDF, DOCX, XLSX, atau PPTX',
        ];
    }
}
