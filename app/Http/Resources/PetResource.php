<?php

namespace App\Http\Resources;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Pet */
class PetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $request->id,
            'name' => $request->name,
            'animal' => AnimalResource::make($request->animal),
            'gender' => $this->gender(),
            'description' => $request->description,
            'created_at' => $request->created_at,
            'updated_at' => $request->updated_at
        ];
    }
}
