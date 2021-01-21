<?php

namespace App\Command;

use App\Pharmacy\CustomPathDecorator;
use App\Pharmacy\Pharmacy;
use App\Product\Product;
use App\Pharmacy\PharmacyCreator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Twig\Environment;

class RenderSingleCardCommand extends Command
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var string
     */
    private $outputDir;

    /**
     * @var PharmacyCreator
     */
    private $pharmacyCreator;

    /**
     * @var ProductInterface[]
     */
    private $products = [];

    /**
     * @param ProductInterface[] $products
     */
    public function __construct(
        Environment $twig,
        string $outputDir,
        PharmacyCreator $pharmacyCreator,
        array $products
    )
    {
        $this->twig = $twig;    
        $this->outputDir = $outputDir;
        $this->pharmacyCreator = $pharmacyCreator;
        foreach ($products as $product) {
            if (!$product instanceof Product) {
                throw new \InvalidArgumentException();
            }
        }

        $this->products = $products;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('generator:render:single');
        $this->addArgument('product', InputArgument::REQUIRED);
        $this->addArgument('pharmacy', InputArgument::REQUIRED);
        $this->addOption('mode', '', InputOption::VALUE_REQUIRED, 'RC generating mode', 'local');
    }

    private function preparePath(Pharmacy $pharmacy, Product $product): string
    {
        return $this->outputDir . DIRECTORY_SEPARATOR . $pharmacy->getCode() . '-' . $product->getCode() . '.html';
    }

    private function getPharmacy(InputInterface $input): Pharmacy
    {
        $pharmacy = $this->pharmacyCreator->create($input->getArgument('pharmacy'));
        if ('local' === $input->getOption('mode')) {
            $pharmacy = new CustomPathDecorator('../build/img', $pharmacy);
        }

        return $pharmacy;
    }

    private function getProduct(string $code): Product
    {
        $products = array_filter($this->products, function (Product $product) use ($code) {
            return $product->getCode() === $code;
        });

        $product = current($products);
        if (!$product instanceof Product) {
            throw new \InvalidArgumentException();
        }

        return $product;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write('> generating... ');
        $product = $this->getProduct($input->getArgument('product'));
        $pharmacy = $this->getPharmacy($input);
        $content = $this->twig->render($product->getCode() . '.html.twig', [
            'product' => $product,
            'pharmacy' => $pharmacy,
            'mode' => 'render',
        ]);

        @unlink($this->preparePath($pharmacy, $product));
        file_put_contents($this->preparePath($pharmacy, $product), $content);
        $output->writeln('done');

        return 0;
    }
}

