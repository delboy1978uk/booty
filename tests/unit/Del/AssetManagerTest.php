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
        $this->booty = new AssetManager();
    }

    protected function _after()
    {
        unset($this->booty);
        unlink('tests/_data/public/some-module');
    }

    /**
     * Check tests are working
     */
    public function testDeploy()
    {
        $am = $this->booty;
        $am->addAssetsFolder('SomeModule', 'tests/_data/SomeModule/data/assets/');
        $am->setDestinationFolder('tests/_data/public/');
        $am->deployAssets();
        $this->assertFileExists('tests/_data/public/some-module/js/test.js');
        $this->assertFileExists('tests/_data/public/some-module/img/me.jpg');
        $this->assertFileExists('tests/_data/public/some-module/css/style.css');
    }
}
