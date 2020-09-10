<?php declare(strict_types=1);

namespace App\Pharmacy;

use App\Product\ProductInterface;

abstract class UlixesBasedPharmacy implements PharmacyInterface
{
    abstract protected function prefixAsset(ProductInterface $product, string $url): string;

    public function transformProductAssetUrl(ProductInterface $product, string $url): string
    {
        return sprintf(
            'https://ulixes.pl/www/images/rc/%s/%s',
            $product->getCode(),
            $this->prefixAsset($product, $url)
        );
    }
}

