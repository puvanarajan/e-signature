<?php

namespace App\Http\Resources\Document;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class SignedDocumentResource
 *
 * This resource transforms the signed document data.
 */
class SignedDocumentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'document_id' => $this->document_id,
            'status' => $this->status,
            'signed_at' => $this->signed_at ? $this->signed_at->toDateTimeString() : null,
            'signed_document' => $this->signed_document_file_path
        ];
    }
}
