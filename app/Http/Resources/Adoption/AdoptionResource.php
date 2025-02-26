<?php

namespace App\Http\Resources\Adoption;

use App\Http\Resources\Animal\AnimalSummaryResource;
use App\Http\Resources\User\UserSummaryResource;
use App\Models\Adoption;
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
/**
 * @mixin Adoption
 */
class AdoptionResource extends JsonResource
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
            'pet' => new AnimalSummaryResource($this->pet),
            'adopter' => new UserSummaryResource($this->user),
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
