<?php

namespace App\Command;

use App\Pharmacy\Pharmacy;
use App\Product\Product;
use App\Pharmacy\PharmacyCreator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Twig\Environment;

class CreateExportPackageCommand extends Command
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
     * @var string
     */
    private $buildDir;

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
        string $buildDir,
        PharmacyCreator $pharmacyCreator,
        array $products
    )
    {
        $this->twig = $twig;    
        $this->outputDir = $outputDir;
        $this->buildDir = $buildDir;
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
        $this->setName('generator:create-export');
        $this->addArgument('pharmacy', InputArgument::REQUIRED);
    }

    private function getPharmacy(InputInterface $input): Pharmacy
    {
        return $this->pharmacyCreator->create($input->getArgument('pharmacy'));
    }

    private function getPharmacyDir(Pharmacy $pharmacy): string
    {
        return $this->outputDir . DIRECTORY_SEPARATOR . $pharmacy->getCode();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write('> generating... ');
        exec('npm run build');
        $pharmacy = $this->getPharmacy($input);
        @mkdir($this->getPharmacyDir($pharmacy) . DIRECTORY_SEPARATOR . 'img', 0777, true);
        foreach (glob($this->buildDir . DIRECTORY_SEPARATOR . 'img/*') as $file) {
            $filename = pathinfo($file, PATHINFO_BASENAME);
            copy($file, $this->getPharmacyDir($pharmacy) . DIRECTORY_SEPARATOR . 'img/'.$filename);
        }

        foreach ($this->products as $product) {
            $content = $this->twig->render($product->getCode() . '.html.twig', [
                'product' => $product,
                'pharmacy' => $pharmacy,
                'mode' => 'export',
            ]);

            file_put_contents(
                $this->getPharmacyDir($pharmacy) . DIRECTORY_SEPARATOR . $product->getCode() . '.html',
                $content
            );
        }

        exec('rm -rf '.$this->getPharmacyDir($pharmacy).'.zip');
        exec('cd '
            .$this->getPharmacyDir($pharmacy).' ; cd .. ; zip -r '
            .$pharmacy->getCode().'.zip '.$pharmacy->getCode());
        exec('rm -rf '.$this->getPharmacyDir($pharmacy));
        $output->writeln('done');

        return 0;
    }
}
