<?php

namespace App\Models;

use App\CustomerStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    public $fillable = [
        'full_name',
        'email',
        'phone',
        'address',
        'status',
        'industry_id',
        'description'
    ];

    public function industry() : BelongsTo
    {
        return $this->belongsTo(Industry::class, 'industry_id', 'id');   
    }

    public function orders() : HasMany {
        return $this->hasMany(Order::class);
    }

    protected function casts() {
        return [
            'status' => CustomerStatus::class
        ];
    }

    
}
