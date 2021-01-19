#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';

use App\Asset\AssetManager;
use App\Command\CreateExportPackageCommand;
use App\Command\RenderSingleCardCommand;
use App\Pharmacy\PharmacyCreator;
use App\Product\Product;
use App\Twig\AssetExtension;
use App\Twig\PharmacyNavigationExtension;
use App\Twig\StringExtension;
use Symfony\Component\Console\Application;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$products = [new Product('product1', 'product')];
$projectDir = realpath(__DIR__);
$loader = new FilesystemLoader(__DIR__ . '/templates');

$twig = new Environment($loader); 
$twig->addExtension(new AssetExtension(new AssetManager($projectDir)));
$twig->addExtension(new StringExtension());
$twig->addExtension(new PharmacyNavigationExtension(__DIR__.'/config/navigation.php'));

$app = new Application();
$renderSingleCardCommand = new RenderSingleCardCommand(
    $twig,
    $projectDir . DIRECTORY_SEPARATOR . 'cards',
    new PharmacyCreator(),
    $products
);

$createExportPackageCommand = new CreateExportPackageCommand(
    $twig,
    $projectDir . DIRECTORY_SEPARATOR . 'cards',
    $projectDir . DIRECTORY_SEPARATOR . 'build',
    new PharmacyCreator(),
    $products
);

$app->add($renderSingleCardCommand);
$app->add($createExportPackageCommand);
$app->run();
