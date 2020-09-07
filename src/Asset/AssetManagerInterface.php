<?php declare(strict_types=1);

namespace App\Asset;

interface AssetManagerInterface
{
    public function hasStyleEntry(string $name): bool;

    public function hasScriptEntry(string $name): bool;

    /**
     * @return string[]
     */
    public function getEntryFiles(string $name): array;

    /**
     * @return string[]
     */
    public function getStyleEntryFiles(string $name): array;

    /**
     * @return string[]
     */
    public function getScriptEntryFiles(string $name): array;
}

