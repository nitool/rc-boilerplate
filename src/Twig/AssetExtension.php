<?php declare(strict_types=1);

namespace App\Twig;

use App\Asset\AssetManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AssetExtension extends AbstractExtension
{
    /**
     * @var AssetManagerInterface
     */
    private $assetManager;

    public function __construct(AssetManagerInterface $assetManager)
    {
        $this->assetManager = $assetManager;    
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('insert_inline_styles', [$this, 'createInlineStyles'], [
                'is_safe' => ['html'],
            ]),
            new TwigFunction('insert_inline_scripts', [$this, 'createInlineScripts'], [
                'is_safe' => ['html'],
            ]),
        ];
    }

    public function createInlineStyles(string $entryName): string
    {
        if (!$this->assetManager->hasStyleEntry($entryName)) {
            return '';
        }

        return sprintf('<style>%s</style>', join('\n', array_map(function (string $file) { 
            return file_get_contents($file); 
        }, $this->assetManager->getStyleEntryFiles($entryName))));
    }

    public function createInlineScripts(string $entryName): string
    {
        if (!$this->assetManager->hasScriptEntry($entryName)) {
            return '';
        }

        return sprintf('<script>%s</script>', join('\n', array_map(function (string $file) { 
            return file_get_contents($file); 
        }, $this->assetManager->getScriptEntryFiles($entryName))));
    }
}

