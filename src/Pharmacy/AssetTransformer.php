<?php

namespace App\Pharmacy;

use App\Product\Product;

class AssetTransformer
{
    /**
     * @var string
     */
    private $template;

    public function __construct(string $template)
    {
        $this->template = $template;    
    }

    public function transform(Pharmacy $pharmacy, Product $product, string $asset): string
    {
        return str_replace([
            '$PHARMACY',
            '$PRODUCT',
            '$ASSET',
        ], [
            $pharmacy->getCode(),
            $product->getCode(),
            $asset,
        ], $this->template);
    }
}

