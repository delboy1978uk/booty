<?php declare(strict_types=1);

namespace Del\Booty;

interface AssetRegistrationInterface
{
    /**
     * @return array
     */
    public function getAssetFolders(): array;
}