<?php

namespace App\Pharmacy;

class AlleccoFactory implements PharmacyFactory
{
    public function create(): Pharmacy
    {
        $transformer = new AssetTransformer('https://ulixes.pl/www/images/rc/$PRODUCT/$ASSET');
        $transformer = new CssPrefixedDecorator($transformer);
        $pharmacy = new Pharmacy('allecco', 1180, $transformer);
        $pharmacy->setScrollingOffset(65);

        return $pharmacy;
    }
}

