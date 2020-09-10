<?php

namespace App\Pharmacy;

use App\Product\Product;

class CssPrefixedDecorator extends AssetTransformerDecorator
{
    /**
     * @var string
     */
    private $prefix = '$PHARMACY';

    public function setPrefix(string $prefix): void
    {
        $this->prefix = $prefix;
    }    

    public function transform(Pharmacy $pharmacy, Product $product, string $asset): string
    {
        if (preg_match('/[.]css$/', $asset)) {
            $asset = $prefix . '-' . $asset;
        }

        parent::transform($pharmacy, $product, $asset);
    }
}

