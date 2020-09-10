<?php

namespace App\Pharmacy;

use App\Product\Product;

abstract class AssetTransformerDecorator extends AssetTransformer
{
    /**
     * @var AssetTransformer
     */
    private $assetTransformer;

    public function __construct(AssetTransformer $assetTransformer)
    {
        $this->assetTransformer = $assetTransformer;    
    }

    public function transform(Pharmacy $pharmacy, Product $product, string $asset): string
    {
        return $this->assetTransformer->transform($pharmacy, $product, $asset);
    }
}

