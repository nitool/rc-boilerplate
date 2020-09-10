<?php declare(strict_types=1);

namespace App\Pharmacy;

use App\Product\ProductInterface;

class Cefarm24 extends UlixesBasedPharmacy
{
    public function getRcContainerWidth(): int
    {
        return 1170;
    }

    public function getScrollingOffset(): int
    {
        return 65;
    }

    protected function prefixAsset(ProductInterface $product, string $url): string
    {
        if (!preg_match('/[.]css$/', $url)) {
            return $url; 
        }

        return 'cefarm-' . $url;
    }
}

