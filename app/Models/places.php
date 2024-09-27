<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class places extends Model
{
    use HasFactory;

    protected $fillable = [
        'place_number',
        'status_id'
    ];

    public function booking()
    {
        return $this->hasOne(booking::class);
    }
}
