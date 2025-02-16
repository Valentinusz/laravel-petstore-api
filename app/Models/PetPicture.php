<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PetPicture extends Model
{
    use HasFactory;

    function pet(): BelongsTo {
        return $this->belongsTo(Pet::class);
    }
}
