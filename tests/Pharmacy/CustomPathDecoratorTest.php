<?php

namespace App\Tests\Pharmacy;

use App\Pharmacy\CustomPathDecorator;
use App\Pharmacy\Melissa;
use App\Product\ProductInterface;
use PHPUnit\Framework\TestCase;

class CustomPathDecoratorTest extends TestCase
{
    /**
     * @covers App\Pharmacy\Melissa
     * @covers App\Pharmacy\CustomPathDecorator
     */
    public function testAssetTransformingWithDecorator(): void
    {
        $product = $this->createMock(ProductInterface::class);
        $product->method('getCode')->willReturn('example_product');
        $pharmacy = new Melissa();
        $this->assertEquals(
            'https://www.apteka-melissa.pl/css/img/example_product/test.png',
            $pharmacy->transformProductAssetUrl($product, 'test.png')
        );

        $decorator = new CustomPathDecorator(__DIR__ . '/test', $pharmacy);
        $this->assertEquals(
            __DIR__ . '/test/test.png',
            $decorator->transformProductAssetUrl($product, 'test.png')
        );
    }
}

