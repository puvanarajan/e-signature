<?php

namespace App\Services\Document;

use App\Classes\ServiceResponse;
use App\Events\DocumentSharedNotificationEvent;
use App\Models\Document;
use App\Repositories\SharedDocumentRepository;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use App\Services\Document\Interfaces\ISharedDocumentServiceInterface;

/**
 * Class SharedDocumentService
 *
 * This service handles the shared document-related operations.
 */
class SharedDocumentService extends BaseService implements ISharedDocumentServiceInterface
{
    private SharedDocumentRepository $sharedDocumentRepository;
    private UserRepository $userRepository;

    /**
     * SharedDocumentService constructor.
     *
     * @param SharedDocumentRepository $sharedDocumentRepository The shared document repository instance.
     * @param UserRepository $userRepository The user repository instance.
     */
    public function __construct(SharedDocumentRepository $sharedDocumentRepository, UserRepository $userRepository)
    {
        $this->sharedDocumentRepository = $sharedDocumentRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Share a document with a user by email.
     *
     * @param Document $document The document to be shared.
     * @param string $email The email of the user to share the document with.
     * @return mixed
     */
    public function shareDocument(Document $document, string $email)
    {
        $user = $this->userRepository->findByEmail($email);
        if (!$user) {
            return $this->prepareResult([]);
        }
        $sharedDocument = $this->sharedDocumentRepository->create([
            'document_id' => $document->id,
            'user_id' => $user->id
        ]);

        event(new DocumentSharedNotificationEvent($sharedDocument));

        return $this->prepareResult($sharedDocument);
    }
}
