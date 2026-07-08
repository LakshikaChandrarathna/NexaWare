<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    use HasFactory;

    protected $table = 'item_categories';

    protected $fillable = [
        'item_category_name',
        'item_category_code',
        'description',
        'cat_radio',
        'isDelete',
        'des_name',
    ];

    protected $casts = [
        'isDelete' => 'boolean',
    ];

    public function subcategories()
    {
        return $this->hasMany(ItemSubCategory::class, 'item_category_id', 'id');
    }
}