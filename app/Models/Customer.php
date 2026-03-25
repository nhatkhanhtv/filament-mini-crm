<?php

namespace App\Models;

use App\CustomerStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    use HasFactory;

    public $fillable = [
        'full_name',
        'email',
        'phone',
        'address',
        'status',
        'industry_id'
    ];

    public function industry() : BelongsTo
    {
        return $this->belongsTo(Industry::class, 'industry_id', 'id');   
    }

    protected function casts() {
        return [
            'status' => CustomerStatus::class
        ];
    }

    
}
