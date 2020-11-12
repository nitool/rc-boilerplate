<?php

namespace App\Tests\Twig;

use App\Twig\StringExtension;
use PHPUnit\Framework\TestCase;

class StringExtensionTest extends TestCase
{
    public function provideTexts(): \Generator
    {
        yield ['i a z d', 'i&nbsp;a&nbsp;z&nbsp;d'];
        yield [
            'Kubek stoi na stole i jest czerwony.',
            'Kubek stoi na&nbsp;stole i&nbsp;jest czerwony.'
        ];

        yield ['zawierający mometazon', 'zawierający mometazon'];
    }

    /**
     * @dataProvider provideTexts
     * @covers StringExtension::addHardSpaces
     */
    public function testHardSpaces(string $subject, string $expected): void
    {
        $extension = new StringExtension();
        $this->assertEquals($expected, $extension->addHardSpaces($subject));
    }
}

