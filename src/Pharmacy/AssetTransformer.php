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

    private function transformPath(
        Pharmacy $pharmacy,
        Product $product,
        string $template,
        string $asset
    ): string
    {
        return str_replace([
            '$PHARMACY',
            '$PRODUCT_MODEL',
            '$PRODUCT',
            '$ASSET',
        ], [
            $pharmacy->getCode(),
            $product->getModel(),
            $product->getCode(),
            $asset,
        ], $template);
    }

    public function transform(Pharmacy $pharmacy, Product $product, string $asset): string
    {
        return $this->transformPath(
            $pharmacy,
            $product,
            $this->template,
            $this->transformPath($pharmacy, $product, $asset, $asset)
        );
    }
}

