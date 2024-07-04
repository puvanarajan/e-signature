<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Class SharedDocument
 *
 * This model represents a shared document entity.
 *
 * @property int $id
 * @property int $document_id
 * @property int $user_id
 * @property string $status
 * @property Carbon|null $signed_at
 * @property string|null $signature_file_name
 * @property string|null $signature_file_path
 * @property string|null $signed_document_file_name
 * @property string|null $signed_document_file_path
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property User $user
 * @property Document $document
 */
class SharedDocument extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shared_documents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'document_id',
        'user_id',
        'status',
        'signed_at',
        'signature_file_name',
        'signature_file_path',
        'signed_document_file_name',
        'signed_document_file_path',
    ];

    /**
     * Get the user that owns the shared document.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the document that is shared.
     *
     * @return BelongsTo
     */
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }
}
