#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';

use App\Asset\AssetManager;
use App\Command\RenderSingleCardCommand;
use App\Twig\AssetExtension;
use Symfony\Component\Console\Application;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/templates');

$twig = new Environment($loader); 
$twig->addExtension(new AssetExtension(new AssetManager(realpath(__DIR__))));

$app = new Application();
$app->add(new RenderSingleCardCommand($twig, realpath(__DIR__) . DIRECTORY_SEPARATOR . 'cards'));
$app->run();

