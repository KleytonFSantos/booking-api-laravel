<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Room extends Model
{
    use HasFactory;

    protected $table = 'room';

    protected $guarded = [];

    public function reservation(): HasOne
    {
        return $this->hasOne(Reservation::class);
    }
}
