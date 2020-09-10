<?php declare(strict_types=1);

namespace App\Pharmacy;

use App\Product\ProductInterface;

/**
 * @todo: Instead of PharmacyInterface create Pharmacy class and create some kind of abstract factory to create each pharmacy
 */
interface PharmacyInterface
{
    public function getRcContainerWidth(): int;

    public function getScrollingOffset(): int;

    public function transformProductAssetUrl(ProductInterface $product, string $url): string;
}

