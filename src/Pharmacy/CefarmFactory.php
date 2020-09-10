<?php

namespace App\Pharmacy;

class CefarmFactory implements PharmacyFactory
{
    public function create(): Pharmacy
    {
        $transformer = new AssetTransformer('https://ulixes.pl/www/images/rc/$PRODUCT/$ASSET');
        $transformer = new CssPrefixedDecorator($transformer);
        $pharmacy = new Pharmacy('cefarm', 1170, $transformer);
        $pharmacy->setScrollingOffset(65);

        return $pharmacy;
    }
}

