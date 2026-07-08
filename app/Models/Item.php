<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';


    protected $fillable = [
        'item_name',
        'item_code',
        'item_no',
        'item_type',
        'item_category',
        'item_sub_category',
        'item_category_generics',
        'item_brand',
        'item_variance_type',
        'item_variance_attribute',
        'item_generic',
        'dimension_type',
        'unit',
        'value',
        'volume',
        'length',
        'metric_units_length',
        'breadth',
        'height',
        'metric_units_breadth',
        'metric_units_height',
        'item_material',
        'item_oem',
        'group_name',
        'loose_main',
        'loose_main_unit',
        'loose_value',
        'loose_value_unit',
        'expiry_date',
        'manufacture_date',
        'usable_days_after_open',
        'warranty_period',
        'key',
        'sales_item',
        'sales_item_name',
        'purchase_item',
        'purchase_item_name',
        'description',
        'description_main',
        'description_sub',
        'isDelete',
        'isUsed',
        'manual_serial',
    ];

   
    protected $casts = [
        'expiry_date'            => 'date',
        'manufacture_date'       => 'date',
        'value'                  => 'decimal:2',
        'volume'                 => 'decimal:2',
        'length'                 => 'decimal:2',
        'breadth'                => 'decimal:2',
        'height'                 => 'decimal:2',
        'usable_days_after_open' => 'integer',
        'isDelete'               => 'boolean',
        'isUsed'                 => 'boolean',
    ];

    public function images()
    {
        return $this->hasMany(ItemImage::class, 'item_id', 'id');
    }
}