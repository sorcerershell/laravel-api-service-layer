<?php


namespace App\Services;


use App\DataTransferObjects\CreateProduct;
use App\Exceptions\ProductAlreadyExistsException;
use App\Exceptions\ValidationException;
use App\Models\Product;
use App\Repositories\ProductRepositoryInterface;

class CreateProductService
{
    private $repository;

    /**
     * CreateProductService constructor.
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->repository = $productRepository;
    }

    /**
     * @param CreateProduct $createProduct
     * @throws ValidationException
     */
    public function handle(CreateProduct $createProduct): ?Product
    {
        $this->validates($createProduct);
        $product = $this->buildProduct($createProduct);
        $this->repository->save($product);
        return $product;
    }

    /**
     * @param CreateProduct $createProduct
     * @throws ValidationException
     */
    private function validates(CreateProduct $createProduct): void
    {
        if ($createProduct->getName() == '') {
            throw new ValidationException('Product Name cannot be empty string');
        }

        if ($createProduct->getId() == null) {
            return;
        }

        if ($this->repository->find($createProduct->getId()) instanceof Product) {
            throw new ProductAlreadyExistsException();
        }
    }

    /**
     * @param CreateProduct $createProduct
     * @return Product
     */
    private function buildProduct(CreateProduct $createProduct): Product
    {
        $product = new Product();
        $product->_id = $createProduct->getId();
        $product->name = $createProduct->getName();
        $product->price = $createProduct->getPrice();
        $product->image = $createProduct->getImage();
        return $product;
    }

}