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
     * @var AssetTransformer
     */
    private $assetTransformer;

    /**
     * @var bool
     */
    private $externalStyles;

    public function __construct(
        string $code,
        AssetTransformer $assetTransformer,
        bool $externalStyles = false
    )
    {
        $this->code = $code;
        $this->assetTransformer = $assetTransformer;
        $this->externalStyles = $externalStyles;
    }

    public function getCode(): string 
    {
        return $this->code;
    }

    public function getAssetPath(Product $product, string $url): string
    {
        return $this->assetTransformer->transform($this, $product, $url);
    }

    public function hasExternalStyles(): bool
    {
        return $this->externalStyles;
    }
}
