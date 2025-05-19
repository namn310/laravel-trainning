<?php

namespace App\Repositories\Interface;

interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    public function getListProductInUserView();
    public function getDetailProductToUpdateRepository(string $id);
    public function getImgProductRepository($id);
    public function deleteImageProductRepository($idImage);
    public function getDetailProductRepository($id);
    public function getRelatedProductRepository($id);
    public function getListProductByNameRepository(string $text);
    public function getListProductByCategoryRepository($idCat);
    public function getListProductBySortRepository($idCat, $field, $sort);
    public function getDiscountProductRepository(string $idPro);
}
