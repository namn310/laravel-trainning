<?php

namespace App\Repositories\Interface;

interface CategoryRepositoryInterface extends BaseRepositoryInterface
{
    public function allWithPaginate();
}
