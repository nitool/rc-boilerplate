<?php

namespace App\Pharmacy;

class ZikoFactory implements PharmacyFactory
{
    public function create(): Pharmacy
    {
        $transformer = new AssetTransformer('/rich-content/$PRODUCT/img/$ASSET');
        $pharmacy = new Pharmacy('ziko', 800, $transformer);
        $pharmacy->setScrollingOffset(65);

        return $pharmacy;
    }
}

