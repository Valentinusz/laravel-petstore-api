<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Adoption extends Model
{
    /**
     * Pet involved in the adoption.
     * @return HasOne
     */
    public function pet(): HasOne
    {
        return $this->hasOne(Pet::class);
    }

    /**
     * User who adopted the pet.
     * @return BelongsTo
     */
    public function user(): HasOne
    {
        return $this->belongsTo(User::class);
    }
}
