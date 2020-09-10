#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';

use App\Asset\AssetManager;
use App\Command\RenderSingleCardCommand;
use App\Pharmacy\PharmacyCreator;
use App\Product\Product;
use App\Twig\AssetExtension;
use Symfony\Component\Console\Application;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$products = [new Product('product1')];
$projectDir = realpath(__DIR__);
$loader = new FilesystemLoader(__DIR__ . '/templates');

$twig = new Environment($loader); 
$twig->addExtension(new AssetExtension(new AssetManager($projectDir)));

$app = new Application();
$renderSingleCardCommand = new RenderSingleCardCommand(
    $twig,
    $projectDir . DIRECTORY_SEPARATOR . 'cards',
    new PharmacyCreator(),
    $products
);

$app->add($renderSingleCardCommand);
$app->run();

