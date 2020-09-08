<?php declare(strict_types=1);

namespace App\Pharmacy;

use App\Product\ProductInterface;

class Melissa implements PharmacyInterface
{
    public function getRcContainerWidth(): int
    {
        return 706;
    }

    public function transformProductAssetUrl(ProductInterface $product, string $asset): string
    {
        return sprintf(
            'https://www.apteka-melissa.pl/css/img/%s/%s',
            $product->getCode(),
            $asset
        );
    }

    public function getScrollingOffset(): int
    {
        return 135;
    }
}

