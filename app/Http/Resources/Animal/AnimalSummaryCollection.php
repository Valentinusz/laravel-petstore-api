<?php

namespace App\Http\Resources\Animal;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: "AnimalSummaryCollection", required: ["data"], properties: [
    new OA\Property(
        property: "data",
        type: "array",
        items: new OA\Items(ref: "#/components/schemas/AnimalSummary")
    )
])]
class AnimalSummaryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
        ];
    }
}
