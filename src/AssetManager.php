<?php

namespace Del\Booty;

class AssetManager
{
    /** @var string[] $assetFolders */
    private $assetFolders = [];

    /** @var string $destinationFolder */
    private $destinationFolder = '';

    /** @var array $deployInfo */
    private $deployInfo = [];

    /**
     * @return string
     */
    public function addAssetsFolder(string $key, string $dir): void
    {
        $dir = realpath($dir);

        if (is_dir($dir)) {
            $this->assetFolders[$key] = $dir;
        }
    }

    /**
     * @return string
     */
    public function setDestinationFolder(string $dir): void
    {
        $dir = realpath($dir);

        if (is_dir($dir)) {
            $this->destinationFolder = $dir;
        }
    }

    /**
     * @return bool
     */
    public function deployAssets(): bool
    {
        foreach ($this->assetFolders as $key => $dir) {
            symlink($dir, $this->destinationFolder . '/' . $key);
        }

        return true;
    }
}