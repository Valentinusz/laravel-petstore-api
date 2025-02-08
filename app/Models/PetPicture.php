<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PetPicture extends Model
{
    function pet(): BelongsTo {
        return $this->belongsTo(Pet::class);
    }
}
