<?php

namespace App\Pharmacy;

class CeneoFactory implements PharmacyFactory
{
    public function create(): Pharmacy
    {
        $transformer = new AssetTransformer('./static/img/$ASSET');
        $transformer = new CssPrefixedDecorator($transformer);
        $pharmacy = new Pharmacy('ceneo', $transformer);

        return $pharmacy;
    }
}

