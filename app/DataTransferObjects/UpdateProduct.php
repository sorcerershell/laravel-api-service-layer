<?php


namespace App\DataTransferObjects;


use Illuminate\Http\Request;

class UpdateProduct
{
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var integer */
    private $price;

    /** @var string|null */
    private $image;

    public static function make(string $id, string $name, int $price, string $image)
    {
        $updateProduct = new self();
        $updateProduct->setId($id);
        $updateProduct->setName($name);
        $updateProduct->setPrice($price);
        $updateProduct->setImage($image);
        return $updateProduct;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return UpdateProduct
     */
    public function setId(string $id): UpdateProduct
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
     * @return UpdateProduct
     */
    public function setName(string $name): UpdateProduct
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
     * @return UpdateProduct
     */
    public function setPrice(int $price): UpdateProduct
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
     * @return UpdateProduct
     */
    public function setImage(?string $image): UpdateProduct
    {
        $this->image = $image;
        return $this;
    }

    public static function fromRequest(Request $request, string $id)
    {
        $updateProduct = new self();
        $updateProduct->setId($id);
        $updateProduct->setName($request->name);
        $updateProduct->setPrice($request->price);
        $updateProduct->setImage($request->image);
        return $updateProduct;
    }

}