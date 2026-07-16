<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HumanContact extends Model
{
    protected $table = 'human_contacts';

    protected $fillable = [
        'human_id',
        'contact_type',
        'country_code',
        'contact_no',
        'is_primary'
    ];

    /**
     * Get the human that owns the contact.
     */
    public function human(): BelongsTo
    {
        return $this->belongsTo(Human::class, 'human_id', 'id');
    }
}