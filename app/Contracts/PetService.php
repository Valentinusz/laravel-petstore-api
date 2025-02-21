<?php

namespace App\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;

interface PetService
{
    /**
     * @param int $page
     * @param int $pageSize
     * @return LengthAwarePaginator<number, LengthAwarePaginator>
     */
    public function findPage(int $page, int $pageSize): LengthAwarePaginator;
}
