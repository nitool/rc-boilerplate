<?php declare(strict_types=1);

namespace App\Asset;

class AssetManager implements AssetManagerInterface
{
    /**
     * @var string
     */
    private $assetDir;

    public function __construct(string $projectDir)
    {
        $this->assetDir = $projectDir . DIRECTORY_SEPARATOR . 'build';        
    }

    /**
     * {@inheritDoc}
     */
    public function getEntryFiles(string $name): array
    {
        $files = [];
        foreach (glob(sprintf('%s/%s.*', $this->assetDir, $name)) as $file) {
            $files[] = realpath($file);
        }

        return $files;
    }

    private function filterByExtension(string $name, string $extension): array
    {
        return array_filter($this->getEntryFiles($name), function (string $file) use ($extension) {
            return preg_match(sprintf('/%s$/', $extension), $file);
        });
    }

    public function hasStyleEntry(string $name): bool
    {
        return !empty($this->filterByExtension($name, 'css'));
    }

    public function hasScriptEntry(string $name): bool
    {
        return !empty($this->filterByExtension($name, 'js'));
   }

    /**
     * {@inheritDoc}
     */
    public function getStyleEntryFiles(string $name): array
    {
        return $this->filterByExtension($name, 'css');
    }

    /**
     * {@inheritDoc}
     */
    public function getScriptEntryFiles(string $name): array
    {
        return $this->filterByExtension($name, 'js');
    }
}

