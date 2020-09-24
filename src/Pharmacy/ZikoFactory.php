<?php

namespace App\Pharmacy;

class ZikoFactory implements PharmacyFactory
{
    public function create(): Pharmacy
    {
        $transformer = new AssetTransformer('/rich-content/$PRODUCT_MODEL/img/$ASSET');
        $pharmacy = new Pharmacy('ziko', $transformer);

        return $pharmacy;
    }
}

