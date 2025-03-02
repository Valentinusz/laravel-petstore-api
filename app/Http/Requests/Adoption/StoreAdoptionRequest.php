<?php

namespace App\Http\Requests\Adoption;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: "StoreAdoptionRequest", required: ["petId"], properties: [
    new OA\Property(property: "petId", type: "integer", example: "1")
])]
class StoreAdoptionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->hasPermissionTo('store adoption');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'petId' => 'exists:pets,id',
        ];
    }
}
