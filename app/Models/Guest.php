<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'guest_count',
        'attendance',
    ];

    public function wishes()
    {
        return $this->hasMany(Wish::class);
    }
}
