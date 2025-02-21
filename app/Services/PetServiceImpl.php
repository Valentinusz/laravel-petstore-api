<?php

namespace App\Services;

use App\Contracts\PetService;
use App\Http\Resources\Pet\PetCollection;
use App\Models\Pet;
use Illuminate\Pagination\LengthAwarePaginator;

class PetServiceImpl implements PetService
{
    public function findPage(int $page, int $pageSize): LengthAwarePaginator {
        return Pet::with("animal")->paginate(
            perPage: $pageSize,
            page: $page
        );
    }
}
