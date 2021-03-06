<?php

namespace App\Pharmacy;

class OlmedFactory implements PharmacyFactory
{
    public function create(): Pharmacy
    {
        $transformer = new AssetTransformer('https://ulixes.pl/www/images/rc/$PRODUCT_MODEL/$ASSET');
        $transformer = new CssPrefixedDecorator($transformer);
        $pharmacy = new Pharmacy('olmed', $transformer);

        return $pharmacy;
    }
}

