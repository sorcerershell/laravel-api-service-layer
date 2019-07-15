<?php


namespace Tests\Unit\Services;


use App\DataObjects\CreateProduct;
use App\Exceptions\ProductAlreadyExistsException;
use App\Exceptions\ValidationException;
use App\Models\Product;
use App\Repositories\ProductRepositoryInterface;
use App\Services\CreateProductService;
use Tests\TestCase;

class CreateProductServiceTest extends TestCase
{
    public function testGivenProductNameIsMissingShouldThrowValidationException()
    {
        $productRepository = $this->getMockBuilder(ProductRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $service = $this->getService($productRepository);

        $createProduct = CreateProduct::make('', 0);

        $this->expectException(ValidationException::class);
        $service->handle($createProduct);
    }

    public function testGivenProductAlreadyExistsShouldThrowException()
    {
        $id = '507f191e810c19729de860ea';
        $productRepository = $this->getMockBuilder(ProductRepositoryInterface::class)
            ->setMethods(['find', 'findAll', 'save', 'delete'])
            ->disableOriginalConstructor()
            ->getMock();

        $productRepository->method('find')
            ->withAnyParameters()
            ->willReturn(new Product(['id' => '507f191e810c19729de860ea', 'name' => 'test', 'price' => 100]));

        $service = $this->getService($productRepository);

        $createProduct = CreateProduct::make('test', 100);
        $createProduct->setId($id);
        $this->expectException(ProductAlreadyExistsException::class);
        $service->handle($createProduct);
    }

    public function testHandleShouldCallProductRepositorySave()
    {
        $productRepository = $this->getMockBuilder(ProductRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $service = $this->getService($productRepository);

        $createProduct = CreateProduct::make('test', 100);

        $productRepository->expects($this->atLeastOnce())
            ->method('save')
            ->withAnyParameters();
        $service->handle($createProduct);
    }

    /**
     * @param \PHPUnit\Framework\MockObject\MockObject $productRepository
     * @return CreateProductService
     */
    private function getService(\PHPUnit\Framework\MockObject\MockObject $productRepository): CreateProductService
    {
        $service = new CreateProductService($productRepository);
        return $service;
    }
}