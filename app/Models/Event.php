<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'event_date',
        'location',
        'description',
        'maps_url',
    ];

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }
}
