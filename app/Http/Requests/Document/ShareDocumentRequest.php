<?php

namespace App\Http\Requests\Document;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ShareDocumentRequest
 *
 * This request class handles the validation for document sharing requests.
 */
class ShareDocumentRequest extends FormRequest
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
            'receiver_emails' => 'required|array',
            'receiver_emails.*' => 'required|email|exists:users,email'
        ];
    }
}
