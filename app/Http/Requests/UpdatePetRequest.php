<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "UpdatePetRequest",
    required: ["name", "is_male", "birth_date", "description", "animal"],
    properties: [
        new OA\Property(property: "name", type: "string", maxLength: 255, example: "Maximus", nullable: false),
        new OA\Property(property: "is_male", type: "boolean", example: false, nullable: false),
        new OA\Property(property: "birth_date", type: "date", nullable: false),
        new OA\Property(property: "description", type: "string", example: "Best boy.", nullable: false),
        new OA\Property(property: "animal", type: "integer", example: 1, nullable: false),
    ]
)]
class UpdatePetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->hasPermissionTo("update pet");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => "required|string|max:255",
            'is_male' => "required|boolean",
            'birth_date' => "required|date",
            'description' => "required|string",
            'animal' => "required|numeric|exists:animals,id",
        ];
    }
}
