<?php

namespace App\Services;

use App\Repositories\Interface\CategoryRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Repositories\Interface\ProductRepositoryInterface;

class ProductService
{
    protected $ProductRepo;
    protected $CategoryRepo;
    public function __construct(ProductRepositoryInterface $productInterface, CategoryRepositoryInterface $categoryInterface)
    {
        $this->ProductRepo = $productInterface;
        $this->CategoryRepo = $categoryInterface;
    }
    public function getListProductInAdmin()
    {
        return $this->ProductRepo->all();
    }
    public function getDetailProductToUpdate(string $idPro)
    {
        return $this->ProductRepo->getDetailProductToUpdateRepository($idPro);
    }
    public function update($id, $data)
    {
        return $this->ProductRepo->update($id, $data);
    }
    public function getImgProduct($id)
    {
        return $this->ProductRepo->getImgProductRepository($id);
    }
    public function getListCategory()
    {
        return $this->CategoryRepo->all();
    }
    public function StoreProduct($request)
    {
        return $this->ProductRepo->create($request);
    }
    public function delete(string $idPro)
    {
        return $this->ProductRepo->delete($idPro);
    }
    public function deleteImageProduct(int $idImage)
    {
        return $this->ProductRepo->deleteImageProductRepository($idImage);
    }
    public function getDetailProduct(string $idPro)
    {
        return $this->ProductRepo->getDetailProductRepository($idPro);
    }
    public function getRelatedProduct(string $idPro)
    {
        return $this->ProductRepo->getRelatedProductRepository($idPro);
    }
    public function getListProductByName(string $text)
    {
        return $this->ProductRepo->getListProductByNameRepository($text);
    }
    public function getListProductByCategory(int $idCat)
    {
        return $this->ProductRepo->getListProductByCategoryRepository($idCat);
    }
    public function getListProductBySort($idCat, $field, $sort)
    {
        return $this->ProductRepo->getListProductBySortRepository($idCat, $field, $sort);
    }
    public function getDiscountProduct(string $idPro)
    {
        return $this->ProductRepo->getDiscountProductRepository($idPro);
    }
}
