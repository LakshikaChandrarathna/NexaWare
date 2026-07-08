<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemSubCategory extends Model
{
    use HasFactory;

  
    protected $table = 'item_sub_categories';


    protected $fillable = [
        'item_category_id',
        'item_sub_category_name',
        'item_sub_category_code',
        'description',
        'isDelete',
        'des_name',
    ];

   
    protected $casts = [
        'item_category_id' => 'integer',
        'isDelete'         => 'boolean',
    ];

    
    public function category()
    {
        return $this->belongsTo(ItemCategory::class, 'item_category_id', 'id');
    }
}