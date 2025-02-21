<?php

namespace App\Http\Requests\Animal;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "UpdateAnimalRequest",
    required: ["name"],
    properties: [
        new OA\Property(property: "name", type: "string", maxLength: 255, example: "Dog", nullable: false)
    ]
)]
class UpdateAnimalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->hasPermissionTo("update animal");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "name" => "required|unique:animals,name|max:255"
        ];
    }
}
