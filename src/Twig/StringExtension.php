<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class StringExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('hard_spaces', [$this, 'addHardSpaces'], [
                'is_safe' => ['html'],
            ]),
        ];
    }

    public function addHardSpaces(string $subject): string
    {
        return preg_replace('/(\b\w{1,2}\b)[ ]/', '$1&nbsp;', $subject);
    }
}

