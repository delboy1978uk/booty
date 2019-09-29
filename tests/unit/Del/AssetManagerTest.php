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
    }

    /**
     * Check tests are working
     */
    public function testBlah()
    {
        $this->assertEquals('Ready to start building tests', $this->booty->blah());
    }


}
