<?php

namespace App\Tests\Pharmacy;

use App\Pharmacy\CustomPathDecorator;
use App\Pharmacy\MelissaFactory;
use App\Pharmacy\Pharmacy;
use App\Product\Product;
use PHPUnit\Framework\TestCase;

class CustomPathDecoratorTest extends TestCase
{
    /**
     * @covers App\Pharmacy\Pharmacy
     * @covers App\Pharmacy\CustomPathDecorator
     */
    public function testAssetTransformingWithDecorator(): void
    {
        $product = new Product('example_product', 'example');
        $pharmacy = (new MelissaFactory())->create();
        $this->assertEquals(
            'https://www.apteka-melissa.pl/css/img/example/test.png',
            $pharmacy->getAssetPath($product, 'test.png')
        );

        $decorator = new CustomPathDecorator(__DIR__ . '/test', $pharmacy);
        $this->assertEquals(
            __DIR__ . '/test/test.png',
            $decorator->getAssetPath($product, 'test.png')
        );
    }
}

