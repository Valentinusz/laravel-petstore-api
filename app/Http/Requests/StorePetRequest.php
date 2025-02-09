<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(title: "StorePetRequest", required: ["name", 'animal', 'gender'], properties: [
    new OA\Property(property: "name", type: 'string', maxLength: 255, example: "Max", nullable: false),
    new OA\Property(property: "animal", type: 'string', example: "Cat", nullable: false),
    new OA\Property(property: "birth_date", type: 'date', nullable: false),
    new OA\Property(property: "gender", type: 'string', enum: ["male", "female"], nullable: false),
])]
class StorePetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'animal' => 'required|exists:App\Models\Animal,name',
            'birth_date' => 'nullable|date',
            'gender' => 'required|in:male,female',
        ];
    }
}
