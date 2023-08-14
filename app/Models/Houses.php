<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Houses extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'user_id',
        'house_details_id',
        'price',
        'sale_price',
        'location_id',
        'adress',
        'city',
        'region',
        'country',
        'zip_code',
        'categories_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function house_details()
    {
        return $this->belongsTo(HouseDetails::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function attachments()
    {
        return $this->belongsToMany(Attachment::class);
    }

    public function categories()
    {
        return $this->belongsTo(Categories::class);
    }

    public function favourites()
    {
        return $this->belongsToMany(Favourite::class);
    }
}
