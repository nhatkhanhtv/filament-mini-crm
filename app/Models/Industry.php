<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Industry extends Model
{
    public $fillable = [
        'name',
        'description',
        'color'
    ];

    public $timestamps = false;

    public function customers() : HasMany {
        return $this->hasMany(Customer::class, 'industry_id', 'id');
    }

    
}
