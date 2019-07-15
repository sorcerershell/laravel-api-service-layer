<?php


namespace App\Repositories;


use App\Models\Product;

interface ProductRepositoryInterface
{
    public function find(string $id) : ?Product;
    public function findAll();
    public function save(Product $product);
    public function delete(string $id) : bool;
}