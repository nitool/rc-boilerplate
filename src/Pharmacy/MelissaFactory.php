<?php

namespace App\Pharmacy;

class MelissaFactory implements PharmacyFactory
{
    public function create(): Pharmacy
    {
        $transformer = new AssetTransformer('https://www.apteka-melissa.pl/css/img/$PRODUCT_MODEL/$ASSET');
        $pharmacy = new Pharmacy('melissa', $transformer);

        return $pharmacy;
    }
}

