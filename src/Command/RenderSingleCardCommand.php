<?php

namespace App\Command;

use App\Pharmacy\Melissa;
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
     * @var ProductInterface[]
     */
    private $products = [];

    /**
     * @param ProductInterface[] $products
     */
    public function __construct(Environment $twig, string $outputDir, array $products)
    {
        $this->twig = $twig;    
        $this->outputDir = $outputDir;
        foreach ($products as $product) {
            if (!$product instanceof ProductInterface) {
                throw new \InvalidArgumentException();
            }
        }

        parent::__construct();
    }

    /**
     * @return PharmacyInterface[]
     */
    private function getPharmacies(): array
    {

    }

    protected function configure()
    {
        $this->setName('generator:render:single');
        $this->addArgument('product', InputArgument::REQUIRED);
        $this->addOption('mode', '', InputOption::REQUIRED, 'RC generating mode', 'local');
        $this->addOption('pharmacy', '', InputOption:REQUIRED, 'Code of pharmacy to render', null);
    }

    private function preparePath(string $name): string
    {
        return $this->outputDir . DIRECTORY_SEPARATOR . $name . '.html';
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write('> generating... ');
        $name = $input->getArgument('name');
        $content = $this->twig->render('base.html.twig', ['name' => $name]);
        @unlink($this->preparePath($name));
        file_put_contents($this->preparePath($name), $content);
        $output->writeln('done');

        return 0;
    }
}

