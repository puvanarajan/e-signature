<?php

namespace App\Services\Document\Interfaces;

use App\Models\Document;

/**
 * Interface ISharedDocumentServiceInterface
 *
 * This interface defines the methods for the shared document service.
 */
interface ISharedDocumentServiceInterface
{
     /**
     * Share a document with a user by email.
     *
     * @param Document $document The document to be shared.
     * @param string $email The email of the user to share the document with.
     * @return mixed
     */
    public function shareDocument(Document $document, string $email);
}
