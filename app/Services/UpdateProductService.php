<?php


namespace App\Services;


use App\DataObjects\UpdateProduct;
use App\Exceptions\ProductIdCannotBeEmptyException;
use App\Exceptions\ProductNotExistsException;
use App\Models\Product;
use App\Repositories\ProductRepositoryInterface;

class UpdateProductService
{

    private $repository;
    /**
     * UpdateProductService constructor.
     * @param ProductRepositoryInterface $repository
     */
    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param UpdateProduct $updateProduct
     * @throws ProductIdCannotBeEmptyException
     * @throws ProductNotExistsException
     */
    public function handle(UpdateProduct $updateProduct)
    {
        $this->validates($updateProduct);
        $existingProduct = $this->findOrError($updateProduct);
        $this->buildProduct($updateProduct, $existingProduct);
        return $existingProduct;
    }

    private function validates(UpdateProduct $updateProduct)
    {
        if ($updateProduct->getId() == null || $updateProduct->getId() == '') {
            throw new ProductIdCannotBeEmptyException();
        }
    }

    /**
     * @param UpdateProduct $updateProduct
     * @param Product|null $existingProduct
     */
    private function buildProduct(UpdateProduct $updateProduct, ?Product $existingProduct): void
    {
        $existingProduct->name = $updateProduct->getName();
        $existingProduct->price = $updateProduct->getPrice();
        $existingProduct->image = $updateProduct->getImage();
        $this->repository->save($existingProduct);
    }

    /**
     * @param UpdateProduct $updateProduct
     * @return Product|null
     * @throws ProductNotExistsException
     */
    private function findOrError(UpdateProduct $updateProduct)
    {
        $existingProduct = $this->repository->find($updateProduct->getId());

        if (!$existingProduct instanceof Product) {
            throw new ProductNotExistsException();
        }
        return $existingProduct;
    }


}