<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'place_id',
        'status_id',
    ];

    public function user()
    {
        return $this->belongsTo(user::class);
    }

   
}
