<?php

namespace Del;

use Del\Booty\AssetManager;

class AssetManagerTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var Blank
     */
    protected $booty;

    protected function _before()
    {
        // create a fresh blank class before each test
        $this->booty = new AssetManager();
    }

    protected function _after()
    {
        // unset the blank class after each test
        unset($this->booty);
        unlink('tests/_data/public/assets/js/test.js');
        unlink('tests/_data/public/assets/img/me.jpg');
        unlink('tests/_data/public/assets/css/style.css');
    }

    /**
     * Check tests are working
     */
    public function testBlah()
    {
        $am = $this->booty;
        $am->addAssetsFolder('tests/_data/some-module/assets/');
        $am->setDestinationFolder('tests/_data/public/assets/');
        $am->deployAssets();
        $this->assertFileExists('tests/_data/public/assets/js/test.js');
        $this->assertFileExists('tests/_data/public/assets/img/me.jpg');
        $this->assertFileExists('tests/_data/public/assets/css/style.css');
    }
}
