<?php declare(strict_types=1);

namespace App\Pharmacy;

use App\Product\ProductInterface;

interface PharmacyInterface
{
    public function getRcContainerWidth(): int;

    public function getScrollingOffset(): int;

    public function transformProductAssetUrl(ProductInterface $product, string $url): string;
}

