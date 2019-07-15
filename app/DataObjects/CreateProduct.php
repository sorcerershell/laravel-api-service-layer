<?php


namespace App\DataObjects;


use App\Http\Requests\CreateProductRequest;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class CreateProduct
{
    /** @var string|null */
    private $id;

    /** @var string */
    private $name;

    /** @var integer */
    private $price;

    /** @var string|null */
    private $image;

    public static function make($name, $price): self
    {
        $createProduct = new self();
        $createProduct->setName($name);
        $createProduct->setPrice($price);
        return $createProduct;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     * @return CreateProduct
     */
    public function setId(?string $id): CreateProduct
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return CreateProduct
     */
    public function setName(string $name): CreateProduct
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     * @return CreateProduct
     */
    public function setPrice(int $price): CreateProduct
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     * @return CreateProduct
     */
    public function setImage(?string $image): CreateProduct
    {
        $this->image = $image;
        return $this;
    }




    public static function fromRequest(Request $request): self
    {
        $createProduct = new CreateProduct();
        $createProduct->setId($request->_id);
        $createProduct->setName($request->name);
        $createProduct->setPrice($request->price);
        $createProduct->setImage($request->image);
        return $createProduct;
    }

}