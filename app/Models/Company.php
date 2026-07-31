<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

   protected $table = 'companies';

    // Allow these columns to accept data
    protected $fillable = [
        'country',
        'country_id',
        'business_type',
        'company_name', 
        'com_code',
        'brc_no',
        'date_of_company_established',
        'province',
        'district',
        'gn_division',
        'house_no',
        'directors',
        'shareholders',
        'owner_id',
        'partner_id',
        'secretaries_id',
        'representative_directors',
        'brc',
        'tax_type',
        'isDelete',
        'address_lines',
        'postal_code',
        'cash_book',
        'bank_book'
    ];


    public function emails()
    {
        return $this->hasMany(CompanyEmail::class, 'company_id');
    }

 
    public function contacts()
    {
        return $this->hasMany(CompanyContact::class, 'company_id');
    }

}
