<?php

namespace App\Http\Resources\Pet;

use App\Http\Resources\Animal\AnimalSummaryResource;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/** @mixin Pet */
#[OA\Schema(
    schema: "Pet",
    required: ["id", "name", "animal", "gender", "created_at", "updated_at"],
    properties: [
        new OA\Property(property: "id", type: "integer", example: 1),
        new OA\Property(property: "name", type: "string", example: "Pet"),
        new OA\Property(property: "animal", ref: "#/components/schemas/AnimalSummary"),
        new OA\Property(property: 'gender', type: "string", enum: ["male", "female"], example: "Male"),
        new OA\Property(property: 'description', type: 'string', example: "Very shy."),
        new OA\Property(property: 'created_at', type: "datetime"),
        new OA\Property(property: 'updated_at', type: "datetime"),
    ]
)]
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
            'id' => $this->id,
            'name' => $this->name,
            'animal' => AnimalSummaryResource::make($this->animal),
            'gender' => $this->gender(),
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
