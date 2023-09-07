<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseComponents extends Model
{
    use HasFactory;
    protected $fillable = [
        'additional',
        'air_condition',
        'courtyard',
        'furniture',
        'gas_stove',
        'internet',
        'tv',
    ];

    public function house()
    {
        return $this->belongsTo(Houses::class);
    }
}
