<?php


namespace Tests\Unit\Services;


use App\DataTransferObjects\CreateProduct;
use App\DataTransferObjects\DeleteProduct;
use App\DataTransferObjects\UpdateProduct;
use App\Exceptions\ProductAlreadyExistsException;
use App\Exceptions\ProductIdCannotBeEmptyException;
use App\Exceptions\ProductNotExistsException;
use App\Exceptions\ValidationException;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Repositories\ProductRepositoryInterface;
use App\Services\DeleteProductService;
use App\Services\UpdateProductService;
use Tests\TestCase;

class DeleteProductServiceTest extends TestCase
{


    public function getService(ProductRepositoryInterface $repository): DeleteProductService
    {
        return new DeleteProductService($repository);
    }


    public function testGivenProductNameIsMissingShouldThrowValidationException()
    {
        $productRepository = $this->getMockBuilder(ProductRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $service = $this->getService($productRepository);

        $updateProduct = DeleteProduct::make('');

        $this->expectException(ProductIdCannotBeEmptyException::class);
        $service->handle($updateProduct);
    }

    public function testGivenProductNotExistsShouldThrowException()
    {
        $id = '507f191e810c19729de860ea';
        $productRepository = $this->getMockBuilder(ProductRepositoryInterface::class)
            ->setMethods(['find', 'findAll', 'save', 'delete'])
            ->disableOriginalConstructor()
            ->getMock();

        $productRepository->method('find')
            ->withAnyParameters()
            ->willReturn(null);

        /** @var UpdateProductService $service */
        $service = $this->getService($productRepository);

        $deleteProduct = DeleteProduct::make($id);
        $this->expectException(ProductNotExistsException::class);
        $service->handle($deleteProduct);
    }

    public function testGivenProductExistsShouldCallRepositoryDelete()
    {
        $id = '507f191e810c19729de860ea';
        $productRepository = $this->getMockBuilder(ProductRepositoryInterface::class)
            ->setMethods(['find', 'findAll', 'save', 'delete'])
            ->disableOriginalConstructor()
            ->getMock();

        $productRepository->method('find')
            ->withAnyParameters()
            ->willReturn(new Product(['id' => $id, 'name' => 'test', 'price' => 10000]));

        /** @var DeleteProductService $service */
        $service = $this->getService($productRepository);

        $deleteProduct = DeleteProduct::make($id);
        $productRepository->expects($this->atLeastOnce())->method('delete')->withAnyParameters();
        $service->handle($deleteProduct);
    }


}