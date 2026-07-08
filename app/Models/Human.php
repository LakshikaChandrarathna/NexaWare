<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Human extends Model
{
   
    protected $table = 'humans';

   
    protected $fillable = [
        'title',
        'fullname',
        'surname',
        'othername',
        'middlename',
        'firstname',
        'gender',
        'dob',
        'NIC',
        'passport',
        'status',
        'created_userid',
        'created_user_role',
        'resident_number',
        'my_number',
        'country',
        'province',
        'discrict',
        'gndivision',
        'house_no',
        'addressone',
        'addresstwo',
        'city',
        'postal_code',
        'isDelete',
        'password' 
    ];

    /**
     * Get all contacts for the human.
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(HumanContact::class, 'human_id', 'id');
    }

    /**
     * Get all emails for the human.
     */
    public function emails(): HasMany
    {
        return $this->hasMany(HumanEmail::class, 'human_id', 'id');
    }

     public function cartitems(): HasMany
    {
        return $this->hasMany(CartItems::class, 'human_id', 'id');
    }

    //  public function  ecomshippingdetails(): HasMany
    // {
    //     return $this->hasMany(ecomShippingDetails::class, 'human_id', 'id');
    // }

    public function provinceRelation()
{
    return $this->belongsTo(\App\Models\Province::class, 'province');
}


 

public function district()
{
    
    return $this->belongsTo(\App\Models\District::class, 'discrict');
}

public function g_n_divisions()
{
     
    return $this->belongsTo(\App\Models\GNDivision::class, 'gndivision'); 
}

 
}