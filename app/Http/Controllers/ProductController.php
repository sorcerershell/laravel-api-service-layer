<?php

namespace App\Http\Controllers;

use App\DataObjects\CreateProduct;
use App\DataObjects\DeleteProduct;
use App\DataObjects\UpdateProduct;
use App\Http\Requests\CreateProductRequest;
use App\Repositories\ProductRepositoryInterface;
use App\Services\CreateProductService;
use App\Services\DeleteProductService;
use App\Services\UpdateProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /** @var CreateProductService */
    private $createProductService;
    /** @var UpdateProductService */
    private $updateProductService;

    /** @var DeleteProductService */
    private $deleteProductServie;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /**
     * ProductController constructor.
     * @param CreateProductService $createProductService
     * @param UpdateProductService $updateProductService
     * @param DeleteProductService $deleteProductService
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        CreateProductService $createProductService,
        UpdateProductService $updateProductService,
        DeleteProductService $deleteProductService,
        ProductRepositoryInterface $productRepository
    ) {
        $this->createProductService = $createProductService;
        $this->updateProductService = $updateProductService;
        $this->deleteProductServie = $deleteProductService;
        $this->productRepository = $productRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $createProduct = CreateProduct::fromRequest($request);
        $result = $this->createProductService->handle($createProduct);
        return $this->sendResponse($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->productRepository->find($id);
        $this->sendResponse($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $updateProduct = UpdateProduct::fromRequest($request);
        $product = $this->updateProductService->handle($updateProduct);
        return $this->sendResponse($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteProduct = DeleteProduct::make($id);
        $deletedProduct = $this->deleteProductServie->handle($deleteProduct);
        return $this->sendResponse([$deletedProduct->_id]);
    }
}
