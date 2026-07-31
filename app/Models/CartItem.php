<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // <-- Add this import

class cartItem extends Model
{
    protected $table = 'cart_items';
    
    protected $fillable = [
        'title',
        'human_id',
        'image_url',
        'quantity',
        'unit_price',
        'total_price',
        'size',  
        'color',
        'order_id',
        'current_status',
        'status',
    ];

    protected $casts = [
    'size' => 'array',
    'color'=>'array',
     // database එකේ size column එක text/json වෙන්න ඕනේ
];

    /**
     * Get the human/buyer that owns the cart item.
     */
    public function human(): BelongsTo
    {
        // This links 'human_id' inside 'cart_items' to the 'id' on your 'humans' table
        return $this->belongsTo(Human::class, 'human_id', 'id');
    }

    protected static function booted()
    {
        static::creating(function ($cartItem) {
            if (empty($cartItem->order_id)) {
                $cartItem->order_id = 'ORD-' . strtoupper(uniqid());
            }
        });
    }



}