<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeAmenities extends Model
{
    use HasFactory;

    protected $fillable = [
        'additional',
        'bus_stop',
        'garden',
        'market',
        'park',
        'parking',
        'school',
        'stadium',
        'subway',
        'super_market',
    ];

    public function house()
    {
        return $this->belongsTo(Houses::class);
    }
}
