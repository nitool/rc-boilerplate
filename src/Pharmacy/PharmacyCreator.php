<?php

namespace App\Pharmacy;

class PharmacyCreator
{
    public function create(string $pharmacy): Pharmacy
    {
        if ('melissa' === $pharmacy) {
            $factory = new MelissaFactory();
        } else if ('wapteka' === $pharmacy) {
            $factory = new WAptekaFactory(); 
        } else if ('ziko' === $pharmacy) {
            $factory = new ZikoFactory(); 
        } else if ('allecco' === $pharmacy) {
            $factory = new AlleccoFactory(); 
        } else if ('cefarm24' === $pharmacy) {
            $factory = new CefarmFactory(); 
        } else if ('zawisza' === $pharmacy) {
            $factory = new ZawiszaFactory(); 
        } else if ('olmed' === $pharmacy) {
            $factory = new OlmedFactory(); 
        } else if ('rosa' === $pharmacy) {
            $factory = new RosaFactory(); 
        } else if ('ceneo' === $pharmacy) {
            $factory = new CeneoFactory(); 
        } else {
            throw new \InvalidArgumentException();
        }

        return $factory->create();
    }
}

