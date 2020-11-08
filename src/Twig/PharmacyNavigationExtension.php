<?php

namespace App\Twig;

use App\Pharmacy\Pharmacy;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class PharmacyNavigationExtension extends AbstractExtension
{
    private $config;

    public function __construct(string $navigationFile) 
    {
        if (!file_exists($navigationFile)) {
            throw new \RuntimeException('given file does not exist');
        }

        $this->config = require $navigationFile;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('hard_spaces', [$this, 'addHardSpaces'], [
                'is_safe' => ['html'],
            ]),
        ];
    }

    private function getDefaultLink(): string
    {
        return 'javascript: void(0);';
    }

    public function getLinkForProduct(Pharmacy $pharmacy, string $productCode): string
    {
        if (!array_key_exists($pharmacy->getCode(), $this->config)) {
            return $this->getDefaultLink();
        }

        $pharmacyNavigation = $this->config[$pharmacy->getCode()];
        if (!array_key_exists($productCode, $pharmacyNavigation)) {
            return $this->getDefaultLink();
        }

        return $pharmacyNavigation[$productCode];
    }
}

