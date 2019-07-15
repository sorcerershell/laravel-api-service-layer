<?php


namespace Tests\Unit\Services;


use App\DataObjects\CreateProduct;
use App\DataObjects\UpdateProduct;
use App\Exceptions\ProductAlreadyExistsException;
use App\Exceptions\ProductIdCannotBeEmptyException;
use App\Exceptions\ValidationException;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Repositories\ProductRepositoryInterface;
use App\Services\UpdateProductService;
use Tests\TestCase;

class UpdateProductServiceTest extends TestCase
{


    public function getService(ProductRepositoryInterface $repository)
    {
        return new UpdateProductService($repository);
    }


    public function testGivenProductNameIsMissingShouldThrowValidationException()
    {
        $productRepository = $this->getMockBuilder(ProductRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $service = $this->getService($productRepository);

        $updateProduct = UpdateProduct::make('', 'test', 10000, 'http://test.com/test.png');

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

        $createProduct = UpdateProduct::make($id, 'test', 10000, 'http://test.com/test.png');
        $createProduct->setId($id);
        $this->expectException(\App\Exceptions\ProductNotExistsException::class);
        $service->handle($createProduct);
    }

    public function testGivenProductExistsShouldCallRepositorySave()
    {
        $id = '507f191e810c19729de860ea';
        $productRepository = $this->getMockBuilder(ProductRepositoryInterface::class)
            ->setMethods(['find', 'findAll', 'save', 'delete'])
            ->disableOriginalConstructor()
            ->getMock();

        $productRepository->method('find')
            ->withAnyParameters()
            ->willReturn(new Product(['id' => $id, 'name' => 'test', 'price' => 10000]));

        /** @var UpdateProductService $service */
        $service = $this->getService($productRepository);

        $newPrice = 20000;
        $newImage = 'http://test.com/test.png';
        $updateProduct = UpdateProduct::make($id, 'test', $newPrice, $newImage);
        $productRepository->expects($this->atLeastOnce())->method('save')->withAnyParameters();
        $service->handle($updateProduct);

    }


}