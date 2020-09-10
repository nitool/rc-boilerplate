<?php declare(strict_types=1);

namespace App\Pharmacy;

use App\Product\ProductInterface;

class Ziko implements PharmacyInterface
{
    public function getRcContainerWidth(): int
    {
        return 800;
    }

    public function transformProductAssetUrl(ProductInterface $product, string $asset): string
    {
        return sprintf(
            '/rich-content/%s/img/%s',
            $product->getCode(),
            $asset
        );
    }

    public function getScrollingOffset(): int
    {
        return 65;
    }
}

