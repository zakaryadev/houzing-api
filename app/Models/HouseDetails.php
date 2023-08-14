<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'num_beds',
        'num_rooms',
        'num_bath',
        'num_garage',
        'area',
        'year_built',
    ];

    public function house()
    {
        return $this->belongsTo(House::class);
    }
}
