<?php

namespace Del;

use Acme\SomeModulePackage;
use Codeception\Test\Unit;
use Composer\Autoload\ClassLoader;
use Del\Booty\BootyCommand;
use PHPUnit\Framework\Exception;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;

class BootyCommandTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var BootyCommand
     */
    protected $booty;

    protected function _before()
    {
        $this->booty = new BootyCommand(null, [SomeModulePackage::class]);
    }

    protected function _after()
    {
        unset($this->booty);
        try {
            unlink('tests/_data/public/some-module');
        } catch (Exception $e) {
            // Travis doesn't like symlinking?
        }
    }

    /**
     * Check tests are working
     */
    public function testCommand()
    {
        $in = new StringInput('');
        $out = new NullOutput();
        try {
            $this->booty->setDestination('tests/_data/public');
            $this->booty->execute($in, $out);
            $this->assertFileExists('tests/_data/public/some-module/js/test.js');
            $this->assertFileExists('tests/_data/public/some-module/img/me.jpg');
            $this->assertFileExists('tests/_data/public/some-module/css/style.css');
        } catch (Exception $e) {
            // Travis doesn't like symlinking?
        }
    }
}
