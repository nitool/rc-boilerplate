<?php declare(strict_types=1);

namespace App\Pharmacy;

use App\Product\ProductInterface;

class Olmed extends UlixesBasedPharmacy
{
    public function getRcContainerWidth(): int
    {
        return 696;
    }

    public function getScrollingOffset(): int
    {
        return 110;
    }

    protected function prefixAsset(ProductInterface $product, string $url): string
    {
        if (!preg_match('/[.]css$/', $url)) {
            return $url; 
        }

        return 'olmed-' . $url;
    }
}

