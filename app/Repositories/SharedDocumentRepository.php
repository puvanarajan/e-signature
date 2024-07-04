<?php

namespace App\Repositories;

use App\Models\SharedDocument;
use App\Repositories\Interfaces\ISharedDocumentRepositoryInterface;

/**
 * Class SharedDocumentRepository
 *
 * This class provides the implementation for the SharedDocument repository.
 */
class SharedDocumentRepository extends BaseRepository implements ISharedDocumentRepositoryInterface
{
    /**
     * SharedDocumentRepository constructor.
     *
     * @param SharedDocument $model The SharedDocument model instance.
     */
    public function __construct(SharedDocument $model)
    {
        $this->model = $model;
    }
}
