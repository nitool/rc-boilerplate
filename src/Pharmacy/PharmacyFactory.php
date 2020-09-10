<?php

namespace App\Pharmacy;

interface PharmacyFactory
{
    public function create(): Pharmacy;
}

