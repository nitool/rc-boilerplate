<?php declare(strict_types=1);

namespace App\Pharmacy;

use App\Product\Product;

abstract class PharmacyDecorator extends Pharmacy
{
    /**
     * @var PharmacyInterface
     */
    private $pharmacy;

    public function __construct(Pharmacy $pharmacy)
    {
        $this->pharmacy = $pharmacy;     
    }

    public function getCode(): string
    {
        return $this->pharmacy->getCode();
    }

    public function getRcContainerWidth(): int
    {
        return $this->pharmacy->getRcContainerWidth();
    }

    public function getScrollingOffset(): int
    {
        return $this->pharmacy->getScrollingOffset();
    }

    public function hasExternalStyles(): bool
    {
        return $this->pharmacy->hasExternalStyles();
    }

    public function setScrollingOffset(int $offset): void
    {
        $this->pharmacy->setScrollingOffset($offset);
    }

    public function transformProductAssetUrl(Product $product, string $url): string
    {
        return $this->pharmacy->transformProductAssetUrl($product, $url);
    }
}

