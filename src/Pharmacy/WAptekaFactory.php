<?php

namespace App\Pharmacy;

class WAptekaFactory implements PharmacyFactory
{
    public function create(): Pharmacy
    {
        $transformer = new AssetTransformer('https://www.wapteka.pl/front/css/$PRODUCT/$ASSET');
        $pharmacy = new Pharmacy('wapteka', 814, $transformer);
        $pharmacy->setScrollingOffset(100);

        return $pharmacy;
    }
}

