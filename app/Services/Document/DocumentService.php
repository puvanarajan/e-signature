<?php

namespace App\Services\Document;

use App\Classes\ServiceResponse;
use App\Enums\DocumentStatus;
use App\Enums\ErrorCode;
use App\Events\DocumentShareEvent;
use App\Http\Requests\Document\CreateDocumentRequest;
use App\Http\Requests\Document\ShareDocumentRequest;
use App\Http\Requests\Document\SignedDocumentRequest;
use App\Models\User;
use App\Repositories\DocumentRepository;
use App\Repositories\SharedDocumentRepository;
use App\Services\BaseService;
use App\Services\Document\Interfaces\IDocumentServiceInterface;
use App\Services\Signature\SignatureService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Class DocumentService
 *
 * This service handles the document-related operations.
 */
class DocumentService extends BaseService implements IDocumentServiceInterface
{
    private DocumentRepository $documentRepository;
    private SharedDocumentRepository $sharedDocumentRepository;

    /**
     * DocumentService constructor.
     *
     * @param DocumentRepository $documentRepository The document repository instance.
     * @param SharedDocumentRepository $sharedDocumentRepository The shared document repository instance.
     */
    public function __construct(DocumentRepository $documentRepository, SharedDocumentRepository $sharedDocumentRepository)
    {
        $this->documentRepository = $documentRepository;
        $this->sharedDocumentRepository = $sharedDocumentRepository;
    }

    /**
     * Handle document upload.
     *
     * @param CreateDocumentRequest $createDocumentRequest The document creation request instance.
     * @param User $user The user instance.
     * @return ServiceResponse The service response.
     */
    public function uploadDocument(CreateDocumentRequest $createDocumentRequest, User $user): ServiceResponse
    {
        $uuid = Str::uuid();
        $uniqueFileName = $uuid . '.' . $createDocumentRequest->file('document')->getClientOriginalExtension();
        $originalFileName = $createDocumentRequest->file('document')->getClientOriginalName();
        $filePath = $createDocumentRequest->file('document')->storeAs('documents', $uniqueFileName);

        $document = $this->documentRepository->create([
            'uuid' => $uuid,
            'user_id' => $user->id,
            'file_name' => $uniqueFileName,
            'file_path' => $filePath,
            'file_original_name' => $originalFileName,
        ]);

        return $this->prepareResult($document);
    }

    /**
     * Handle document sharing.
     *
     * @param ShareDocumentRequest $shareDocumentRequest The document sharing request instance.
     * @return ServiceResponse The service response.
     */
    public function shareDocument(ShareDocumentRequest $shareDocumentRequest): ServiceResponse
    {
        $document = $this->getDocument($shareDocumentRequest->get('document_id'));
        event(new DocumentShareEvent($document, $shareDocumentRequest->get('receiver_emails')));

        return $this->prepareResult([], true, 'Successfully shared.');
    }

    /**
     * Get a document by ID.
     *
     * @param int $documentId The document ID.
     * @return mixed The document instance.
     */
    public function getDocument($documentId)
    {
        return $this->documentRepository->find($documentId);
    }

    /**
     * Handle document signing.
     *
     * @param SignedDocumentRequest $signedDocumentRequest The signed document request instance.
     * @param User $user The user instance.
     * @return mixed.
     */
    public function signedDocument(SignedDocumentRequest $signedDocumentRequest, User $user): ServiceResponse
    {
        $document = $this->documentRepository->find($signedDocumentRequest->get('document_id'));

        $sharedDocument = $this->sharedDocumentRepository->findByConditions([
            ['filed' => 'user_id', 'condition' => '=', 'value' => $user->id],
            ['filed' => 'document_id', 'condition' => '=', 'value' => $document->id],
        ])->first();

        if (!$sharedDocument) {
            return $this->prepareResult([], false, 'Document not found', ErrorCode::MODEL_NOT_FOUND->value);
        }

        if ($sharedDocument->status == DocumentStatus::SIGNED->value) {
            return $this->prepareResult([], false, 'Document already signed', ErrorCode::ALREADY_SIGNED->value);
        }

        $uniqueFileName = $document->uuid . '.' . $signedDocumentRequest->file('signature')->getClientOriginalExtension();
        $signatureFilePath = $signedDocumentRequest->file('signature')->storeAs('signature', $uniqueFileName);
        $outputPath = storage_path('app/signed_documents/' . $document->uuid . '.pdf');

        $this->sharedDocumentRepository->updateByModelObject($sharedDocument, [
            'status' => DocumentStatus::SIGNED->value,
            'signed_at' => Carbon::now(),
            'signature_file_name' => $uniqueFileName,
            'signature_file_path' => $signatureFilePath,
            'signed_document_file_name' => $document->uuid . '.pdf',
            'signed_document_file_path' => $outputPath,
        ]);

        (new SignatureService())->generateSignature(Storage::path($document->file_path), Storage::path($signatureFilePath), $outputPath);

        return $this->prepareResult($sharedDocument, true, 'Successfully Signed.');
    }
}
