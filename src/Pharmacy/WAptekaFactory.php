<?php

namespace App\Pharmacy;

class WAptekaFactory implements PharmacyFactory
{
    public function create(): Pharmacy
    {
        $transformer = new AssetTransformer('https://www.wapteka.pl/front/css/$PRODUCT_MODEL/$ASSET');
        $pharmacy = new Pharmacy('wapteka', $transformer);

        return $pharmacy;
    }
}

