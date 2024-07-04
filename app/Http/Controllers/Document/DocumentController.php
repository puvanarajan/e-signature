<?php

namespace App\Http\Controllers\Document;

use App\Http\Controllers\Controller;
use App\Http\Requests\Document\CreateDocumentRequest;
use App\Http\Requests\Document\ShareDocumentRequest;
use App\Http\Requests\Document\SignedDocumentRequest;
use App\Http\Resources\Document\DocumentResource;
use App\Http\Resources\Document\SharedDocumentResource;
use App\Http\Resources\Document\SignedDocumentResource;
use App\Services\Document\DocumentService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Class DocumentController
 *
 * This controller handles document-related actions such as upload, share, and sign.
 */
class DocumentController extends Controller
{
    /**
     * @var DocumentService The document service instance.
     */
    private DocumentService $documentService;

    /**
     * Create a new controller instance.
     *
     * @param DocumentService $documentService The document service instance.
     */
    public function __construct(DocumentService $documentService) {
        $this->documentService = $documentService;
    }

    /**
     * Handle a document upload request.
     *
     * @param CreateDocumentRequest $createDocumentRequest The request instance containing document upload data.
     * @return JsonResponse The JSON response with the upload result.
     */
    public function documentUpload(CreateDocumentRequest $createDocumentRequest)
    {
        $document = $this->documentService->uploadDocument($createDocumentRequest, Auth::user());
        return $this->sendJsonResponse(new DocumentResource($document->data), $document->status, $document->message);
    }

    /**
     * Handle a document share request.
     *
     * @param ShareDocumentRequest $shareDocumentRequest The request instance containing document share data.
     * @return JsonResponse The JSON response with the share result.
     * @throws AuthorizationException
     */
    public function shareDocument(ShareDocumentRequest $shareDocumentRequest)
    {
        $this->authorize('share', $this->documentService->getDocument($shareDocumentRequest->get('document_id')));

        $document = $this->documentService->shareDocument($shareDocumentRequest);
        return $this->sendJsonResponse(new SharedDocumentResource($document->data), $document->status, $document->message);
    }

    /**
     * Handle a document sign request.
     *
     * @param SignedDocumentRequest $signedDocumentRequest The request instance containing document sign data.
     * @return JsonResponse The JSON response with the sign result.
     */
    public function signedDocument(SignedDocumentRequest $signedDocumentRequest)
    {
        $sharedDocument = $this->documentService->signedDocument($signedDocumentRequest, Auth::user());
        if ($sharedDocument->status) {
            return $this->sendSuccessResponse(new SignedDocumentResource($sharedDocument->data), $sharedDocument->message);
        }
        return $this->sendErrorResponse($sharedDocument->data, $sharedDocument->message);
    }
}
