<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "PetPicture")]
class PetPictureController extends Controller
{
    #[OA\Post(path: '/api/v1/pets/{petId}/pet-pictures', summary: 'Get a page of pets', tags: ["PetPicture"])]
    #[OA\Response(response: 201, description: "Created")]
    public function store() {
    }

    #[OA\Delete(path: '/api/v1/pet-pictures/{pictureId}', summary: 'Get a page of pets', tags: ["PetPicture"])]
    #[OA\Response(response: 204, description: "Deleted")]
    public function destroy() {
    }
}
