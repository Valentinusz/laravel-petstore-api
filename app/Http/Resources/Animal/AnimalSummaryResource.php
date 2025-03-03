<?php

namespace App\Http\Resources\Animal;

use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/** @mixin Animal */
#[OA\Schema(
    schema: 'AnimalSummary',
    required: ["id", "name"],
    properties: [
        new OA\Property(property: "id", type: "integer", example: 1),
        new OA\Property(property: "name", type: "string", example: "Cat")
    ]
)]
class AnimalSummaryResource extends JsonResource
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
            'name' => $this->name
        ];
    }
}
