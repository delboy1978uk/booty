# booty
[![Latest Stable Version](https://poser.pugx.org/delboy1978uk/booty/v/stable)](https://packagist.org/packages/delboy1978uk/booty) [![Total Downloads](https://poser.pugx.org/delboy1978uk/booty/downloads)](https://packagist.org/packages/delboy1978uk/booty) [![Latest Unstable Version](https://poser.pugx.org/delboy1978uk/booty/v/unstable)](https://packagist.org/packages/delboy1978uk/booty) [![License](https://poser.pugx.org/delboy1978uk/booty/license)](https://packagist.org/packages/delboy1978uk/booty)<br />
![build status](https://github.com/delboy1978uk/booty/actions/workflows/master.yml/badge.svg) [![Code Coverage](https://scrutinizer-ci.com/g/delboy1978uk/booty/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/delboy1978uk/booty/?branch=master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/delboy1978uk/booty/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/delboy1978uk/booty/?branch=master) <br />
Booty is an asset deployment tool (with an optional cli command for use with Bone Framework). v1.x currently takes an array of source folders with a key, and 
deploys a symlink to your destination folder (usually your web server's `public/` folder) 
## installation
`
composer require delboy1978uk/booty
` 
## usage
When adding an asset folder, the key name will be converted from any `CapsOrCamelCaseEtc` to `caps-or-camel-case-etc` 
in the symlink, for better URLs.
```php
<?php

use Del\Booty\AssetManager;

$am = new AssetManager();
$am->addAssetsFolder('some', 'some/folder/with/css/js/etc');
$am->addAssetsFolder('another', 'another/folder/with/css/js/etc');
$am->setDestinationFolder('/var/www/html/public/');
$am->deployAssets();
```
## bone cli usage
This command will pick up all Bone Framework `src/` and `vendor/` packages and use the asset manager to deploy the 
files to the `public/` directory. In your terminal:
```
bone assets:deploy
```
or aliased:
```
bone a:d
```
