<?php declare(strict_types=1);

namespace App\Pharmacy;

use App\Product\Product;

class Pharmacy
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var int
     */
    private $containerWidth;

    /**
     * @var int
     */
    private $scrollingOffset = 0;

    /**
     * @var AssetTransformer
     */
    private $assetTransformer;

    public function __construct(string $code, int $containerWidth, AssetTransformer $assetTransformer)
    {
        $this->containerWidth = $containerWidth;
        $this->code = $code;
        $this->assetTransformer = $assetTransformer;
    }

    public function getRcContainerWidth(): int
    {
        return $this->containerWidth;
    }

    public function setScrollingOffset(int $offset): void
    {
        $this->scrollingOffset = $offset;
    }

    public function getScrollingOffset(): int
    {
        return $this->scrollingOffset;
    }

    public function getCode(): string 
    {
        return $this->code;
    }

    public function transformProductAssetUrl(Product $product, string $url): string
    {
        return $this->assetTransformer->transform($this, $product, $url);
    }
}

