<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Animal extends Model
{
    /**
     * There can be many pets of the same animal.
     * @return HasMany
     */
    public function Pets(): HasMany {
        return $this->hasMany(Pet::class);
    }
}
