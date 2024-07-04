<?php

namespace App\Repositories;

use App\Models\Document;
use App\Repositories\Interfaces\IDocumentRepositoryInterface;

/**
 * Class DocumentRepository
 *
 * This class provides the implementation for the Document repository.
 */
class DocumentRepository extends BaseRepository implements IDocumentRepositoryInterface
{
    /**
     * DocumentRepository constructor.
     *
     * @param Document $document The Document model instance.
     */
    public function __construct(Document $document)
    {
        $this->model = $document;
    }
}
