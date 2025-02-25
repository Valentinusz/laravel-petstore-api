<?php

namespace App\Http\Resources\Adoption;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Adoption",
    required: ["id"],
    properties: [
        new OA\Property(property: "id", type: "integer", example: 1)
    ]
)]
class AdoptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
