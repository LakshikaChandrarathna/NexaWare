<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupName extends Model
{
    use HasFactory;

    // 1. Explicitly point to your custom table name
    protected $table = 'group_names';

    // 2. Define the primary key if it's named 'id' (optional, but good practice)
    protected $primaryKey = 'id';

    // 3. Define mass-assignable attributes (needed for firstOrCreate / create)
    protected $fillable = [
        'group_name',
        'description',
        'isDelete',
    ];

    // 4. Default values for new model instances
    protected $attributes = [
        'isDelete' => 0, // Defaults to not deleted
    ];

    /**
     * Relationship: A group can belong to many items as a category.
     */
    public function itemsByCategory()
    {
        return $this->hasMany(Item::class, 'item_category', 'id');
    }

    /**
     * Relationship: A group can belong to many items as a sub-category.
     */
    public function itemsBySubCategory()
    {
        return $this->hasMany(Item::class, 'item_sub_category', 'id');
    }
}