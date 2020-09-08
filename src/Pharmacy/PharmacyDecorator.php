<?php declare(strict_types=1);

namespace App\Pharmacy;

use App\Product\ProductInterface;

abstract class PharmacyDecorator implements PharmacyInterface
{
    /**
     * @var PharmacyInterface
     */
    private $pharmacy;

    public function __construct(PharmacyInterface $pharmacy)
    {
        $this->pharmacy = $pharmacy;     
    }

    public function getRcContainerWidth(): int
    {
        return $this->pharmacy->getRcContainerWidth();
    }

    public function getScrollingOffset(): int
    {
        return $this->pharmacy->getScrollingOffset();
    }

    public function transformProductAssetUrl(ProductInterface $product, string $url): string
    {
        return $this->pharmacy->transformProductAssetUrl($product, $url);
    }
}

