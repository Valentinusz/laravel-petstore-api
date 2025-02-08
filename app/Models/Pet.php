<?php

namespace App\Models;

use Database\Factories\PetFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pet extends Model
{
    /** @use HasFactory<PetFactory> */
    use HasFactory;

    protected $fillable = ["name", "description", "is_male", "birth_date", "available", "animal_id"];

    /**
     * Get the user's first name.
     */
    public function gender(): string
    {
        return $this->is_male ? "male" : "female";
    }

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
