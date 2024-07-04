<?php

namespace App\Services\Document\Interfaces;

use App\Http\Requests\Document\CreateDocumentRequest;
use App\Http\Requests\Document\ShareDocumentRequest;
use App\Http\Requests\Document\SignedDocumentRequest;
use App\Models\User;
use App\Classes\ServiceResponse;

/**
 * Interface IDocumentServiceInterface
 *
 * This interface defines the methods for the document service.
 */
interface IDocumentServiceInterface
{
    /**
     * Handle document upload.
     *
     * @param CreateDocumentRequest $createDocumentRequest The document creation request instance.
     * @param User $user The user instance.
     * @return ServiceResponse The service response.
     */
    public function uploadDocument(CreateDocumentRequest $createDocumentRequest, User $user): ServiceResponse;

    /**
     * Handle document sharing.
     *
     * @param ShareDocumentRequest $shareDocumentRequest The document sharing request instance.
     * @return ServiceResponse The service response.
     */
    public function shareDocument(ShareDocumentRequest $shareDocumentRequest): ServiceResponse;

    /**
     * Handle document signing.
     *
     * @param SignedDocumentRequest $signedDocumentRequest The signed document request instance.
     * @param User $user The user instance.
     * @return ServiceResponse The service response.
     */
    public function signedDocument(SignedDocumentRequest $signedDocumentRequest, User $user): ServiceResponse;
}
