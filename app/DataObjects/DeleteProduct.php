<?php


namespace App\DataObjects;


use Illuminate\Http\Request;

class DeleteProduct
{
    /**
     * @var string
     */
    private $id;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return DeleteProduct
     */
    public function setId(string $id): DeleteProduct
    {
        $this->id = $id;
        return $this;
    }

    public static function make(string $id): self
    {
        $self = new self();
        $self->setId($id);
        return $self;
    }
}