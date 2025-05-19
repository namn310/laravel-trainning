<?php

namespace App\Services;

use App\Repositories\Interface\CategoryRepositoryInterface;

class CategoryService
{
    protected $CateRepo;
    public function __construct(CategoryRepositoryInterface $CateRepo)
    {
        $this->CateRepo = $CateRepo;
    }
    public function getAllNoPaginate()
    {
        return $this->CateRepo->all();
    }
    public function getAllHasPaginate()
    {
        return $this->CateRepo->allWithPaginate();
    }
    public function createCategory($data)
    {
        return $this->CateRepo->create($data);
    }
    public function deleteCategory($idCat)
    {
        return $this->CateRepo->delete($idCat);
    }
    public function updateCategory($idCat, $data)
    {
        return $this->CateRepo->update($idCat, $data);
    }
}
