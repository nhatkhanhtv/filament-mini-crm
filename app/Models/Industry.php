<?php

namespace App\Models;

use App\Policies\IndustryPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[UsePolicy(IndustryPolicy::class)]
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
