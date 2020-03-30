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
            $key = $this->camelCaseToDash($key);
            $linkFolder = $this->destinationFolder . '/' . $key;

            if (!file_exists($linkFolder)) {
                symlink($dir, $linkFolder);
            }
        }

        return true;
    }

    /**
     * @param string $key
     * @return string
     */
    private function camelCaseToDash(string $key): string
    {
        $newKey = '';

        foreach (str_split($key) as $index => $letter) {
            if (ctype_upper($letter)) {
                $letter = strtolower($letter);
                $letter = $index < 1 ? $letter : '-' . $letter;
            }
            $newKey .= $letter;
        }

        return $newKey;
    }
}