<?php


namespace App\Repositories;


use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function find(string $id): ?Product
    {
        return Product::where('_id', $id)->first();
    }

    public function findAll()
    {
        return Product::all();
    }

    public function save(Product $product)
    {
        return $product->save();
    }

    public function delete(string $id): bool
    {
        return Product::destroy($id);
    }
}