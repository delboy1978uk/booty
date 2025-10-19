<?php

namespace Acme;

use Del\Booty\AssetRegistrationInterface;

class SomeModulePackage implements AssetRegistrationInterface
{
    public function getAssetFolders(): array
    {
        return [
            'some-module' => __DIR__ . '/../data/assets',
        ];
    }
}
