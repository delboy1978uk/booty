<?php

namespace Del\Booty;

class AssetManager
{
    private array $assetFolders = [];
    private string $destinationFolder = '';

    public function addAssetsFolder(string $key, string $dir): void
    {
        $dir = realpath($dir);

        if (is_dir($dir)) {
            $this->assetFolders[$key] = $dir;
        }
    }

    public function setDestinationFolder(string $dir): void
    {
        $dir = realpath($dir);

        if (is_dir($dir)) {
            $this->destinationFolder = $dir;
        }
    }

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
