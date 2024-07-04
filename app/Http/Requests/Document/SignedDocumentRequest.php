<?php

namespace App\Http\Requests\Document;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SignedDocumentRequest
 *
 * This request class handles the validation for signed document requests.
 */
class SignedDocumentRequest extends FormRequest
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
            'document_id' => 'required|integer|exists:documents,id',
            'signature' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}
