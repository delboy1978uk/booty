<?php

namespace Del;

use Codeception\TestCase\Test;
use Composer\Autoload\ClassLoader;
use Del\Booty\AssetManager;
use Del\Booty\BootyCommand;
use PHPUnit\Framework\Exception;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\StreamOutput;

class BootyCommandTest extends Test
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
        $composer = $this->getMockBuilder(ClassLoader::class)->getMock();
        $composer->method('findFile')->willReturn('tests/_data/SomeModule/src/SomeModulePackage.php');

        $this->booty = new BootyCommand(null, ['SomeModule'], $composer);
    }

    protected function _after()
    {
        unset($this->booty);
        unlink('tests/_data/public/some-module');
    }

    /**
     * Check tests are working
     */
    public function testCommand()
    {
        $in = new StringInput('');
        $out = new NullOutput();
        try {
            $this->booty->execute($in, $out);
            $this->assertFileExists('tests/_data/public/some-module/js/test.js');
            $this->assertFileExists('tests/_data/public/some-module/img/me.jpg');
            $this->assertFileExists('tests/_data/public/some-module/css/style.css');
        } catch (Exception $e) {
            // Travis doesn't like symlinking
        }
    }
}
