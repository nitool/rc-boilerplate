<?php declare(strict_types=1);

namespace App\Pharmacy;

use App\Product\ProductInterface;

class CustomPathDecorator extends PharmacyDecorator
{
    /**
     * @var string
     */
    private $customPath;

    public function __construct(string $customPath, PharmacyInterface $pharmacy)
    {
        $this->customPath = $customPath;
        parent::__construct($pharmacy);    
    }

    public function transformProductAssetUrl(ProductInterface $product, string $url): string
    {
        return $this->customPath . DIRECTORY_SEPARATOR . $url;
    }
}

