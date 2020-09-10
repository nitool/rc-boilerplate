<?php

namespace App\Pharmacy;

class MelissaFactory implements PharmacyFactory
{
    public function create(): Pharmacy
    {
        $transformer = new AssetTransformer('https://www.apteka-melissa.pl/css/img/$PRODUCT/$ASSET');
        $pharmacy = new Pharmacy('melissa', 706, $transformer);
        $pharmacy->setScrollingOffset(135);

        return $pharmacy;
    }
}

