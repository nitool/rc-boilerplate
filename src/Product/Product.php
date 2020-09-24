<?php declare(strict_types=1);

namespace App\Product;

class Product
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $model;

    public function __construct(string $code, string $model)
    {
        $this->code = $code;
        $this->model = $model;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getModel(): string
    {
        return $this->model;
    }
}
