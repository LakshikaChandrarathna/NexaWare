<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HumanEmail extends Model
{
    protected $table = 'human_emails';

    protected $fillable = [
        'human_id',
        'email',
        'is_primary'
    ];

    /**
     * Get the human that owns the email.
     */
    public function human(): BelongsTo
    {
        return $this->belongsTo(Human::class, 'human_id', 'id');
    }
}