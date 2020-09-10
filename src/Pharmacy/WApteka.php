<?php declare(strict_types=1);

namespace App\Pharmacy;

use App\Product\ProductInterface;

class WApteka implements PharmacyInterface
{
    public function getRcContainerWidth(): int
    {
        return 814;
    }

    public function transformProductAssetUrl(ProductInterface $product, string $asset): string
    {
        return sprintf(
            'https://www.wapteka.pl/front/css/%s/%s',
            $product->getCode(),
            $asset
        );
    }

    public function getScrollingOffset(): int
    {
        return 100;
    }
}

