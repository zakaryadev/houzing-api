<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttachmentHouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'houses_id',
        'attachment_id',
    ];

    public function house()
    {
        return $this->belongsTo(Houses::class);
    }

    public function attachment()
    {
        return $this->belongsTo(Attachment::class);
    }
}
