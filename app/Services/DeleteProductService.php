<?php


namespace App\Services;


use App\DataTransferObjects\DeleteProduct;
use App\DataTransferObjects\UpdateProduct;
use App\Exceptions\ProductIdCannotBeEmptyException;
use App\Exceptions\ProductNotExistsException;
use App\Models\Product;
use App\Repositories\ProductRepositoryInterface;

class DeleteProductService
{
    /**
     * @var ProductRepositoryInterface
     */
    private $repository;

    /**
     * DeleteProductService constructor.
     * @param ProductRepositoryInterface $repository
     */
    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(DeleteProduct $deleteProduct)
    {
        $this->validates($deleteProduct);
        $existingProduct = $this->findOrError($deleteProduct);
        $this->deleteProduct($deleteProduct);
        return $existingProduct;
    }

    /**
     * @param DeleteProduct $updateProduct
     * @throws ProductIdCannotBeEmptyException
     */
    private function validates(DeleteProduct $updateProduct): void
    {
        if ($updateProduct->getId() == '' || $updateProduct->getId() == null) {
            throw new ProductIdCannotBeEmptyException();
        }
    }

    /**
     * @param DeleteProduct $updateProduct
     * @return Product|null
     * @throws ProductNotExistsException
     */
    private function findOrError(DeleteProduct $updateProduct)
    {
        $existingProduct = $this->repository->find($updateProduct->getId());
        if (!$existingProduct instanceof Product) {
            throw new ProductNotExistsException();
        }
        return $existingProduct;
    }

    /**
     * @param Product|null $existingProduct
     */
    private function deleteProduct(DeleteProduct $deleteProduct): void
    {
        $this->repository->delete($deleteProduct->getId());
    }


}