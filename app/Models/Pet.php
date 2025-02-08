<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pet extends Model
{
    /**
     * An animal has a species.
     * @return BelongsTo
     */
    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class);
    }

    public function adoption(): BelongsTo {
        return $this->belongsTo(Adoption::class);
    }
}
