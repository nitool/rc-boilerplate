<?php

namespace App\Pharmacy;

class ZawiszaFactory implements PharmacyFactory
{
    public function create(): Pharmacy
    {
        $transformer = new AssetTransformer('https://ulixes.pl/www/images/rc/$PRODUCT/$ASSET');
        $transformer = new CssPrefixedDecorator($transformer);
        $pharmacy = new Pharmacy('zawisza', 1158, $transformer);
        $pharmacy->setScrollingOffset(65);

        return $pharmacy;
    }
}

