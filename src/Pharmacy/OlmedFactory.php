<?php

namespace App\Pharmacy;

class OlmedFactory implements PharmacyFactory
{
    public function create(): Pharmacy
    {
        $transformer = new AssetTransformer('https://ulixes.pl/www/images/rc/$PRODUCT/$ASSET');
        $transformer = new CssPrefixedDecorator($transformer);
        $pharmacy = new Pharmacy('olmed', 696, $transformer);
        $pharmacy->setScrollingOffset(110);

        return $pharmacy;
    }
}

