<?php

namespace App\Tests\Twig;

use App\Pharmacy\AssetTransformer;
use App\Pharmacy\Pharmacy;
use App\Twig\PharmacyNavigationExtension;
use PHPUnit\Framework\TestCase;

class PharmacyNavigationExtensionTest extends TestCase
{
    /**
     * @var string|null
     */
    private $filename;

    private function createNavigationFile(array $data): void
    {
        $pharmacies = [];
        foreach ($data as $pharmacy => $products) {
            $links = [];
            foreach ($products as $product => $link) {
                $links[] = "'$product' => '$link',";
            }

            $pharmacies[] = implode("\n", [
                "'$pharmacy' => [",
                implode("\n", $links),
                '],',
            ]);
        }

        $array = implode("\n", $pharmacies);
        $contents = <<<EOT
<?php

return [
    {$array} 
];
EOT;

        $this->filename = __DIR__.'navigation_'.uniqid().'.php';
        file_put_contents($this->filename, $contents);
    }

    public function provideNavigation(): \Generator
    {
        yield [
            'product' => 'product1',
            'pharmacy' => 'cefarm24',
            'expectedLink' => 'https://cefarm24.pl/testowy_produkt',
            'data' => [
                'cefarm24' => [
                    'product1' => 'https://cefarm24.pl/testowy_produkt',
                    'product2' => 'https://cefarm24.pl/testowy_produkt2',
                ],
            ],
        ];

        yield [
            'product' => 'product3',
            'pharmacy' => 'cefarm24',
            'expectedLink' => 'javascript: void(0);',
            'data' => [
                'cefarm24' => [
                    'product1' => 'https://cefarm24.pl/testowy_produkt',
                    'product2' => 'https://cefarm24.pl/testowy_produkt2',
                ],
            ],
        ];
    }

    /**
     * @dataProvider provideNavigation
     */
    public function testLinkForGivenProduct(string $product, string $pharmacy, string $expectedLink, array $data): void
    {
        $this->createNavigationFile($data);
        $extension = new PharmacyNavigationExtension($this->filename);
        $pharmacy = new Pharmacy($pharmacy, new AssetTransformer(''));
        $this->assertSame($expectedLink, $extension->getLinkForProduct($pharmacy, $product));
    }

    public function tearDown(): void
    {
        unlink($this->filename);
    }
}