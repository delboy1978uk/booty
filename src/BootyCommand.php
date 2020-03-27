<?php

namespace Del\Booty;

use Composer\Autoload\ClassLoader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BootyCommand extends Command
{
    /** @var array */
    private $packages;

    /** @var AssetManager $booty */
    private $booty;

    /** @var ClassLoader $composer */
    private $composer;

    /** @var string $destination */
    private $destination = 'public/';

    public function __construct(string $name = null, array $packages, ClassLoader $composer)
    {
        parent::__construct($name);
        $this->packages = $packages;
        $this->booty = new AssetManager();
        $this->composer = $composer;
    }

    protected function configure()
    {
        parent::configure();
        $this->setName('deploy');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->booty->setDestinationFolder($this->destination);
        foreach ($this->packages as $package) {
            $moduleName = str_replace('Package', '', $package);
            $explosion = explode('\\', $moduleName);
            $moduleName = end($explosion);
            $file = realpath($this->composer->findFile($package));
            $folder = dirname($file);
            $folder = substr($folder, -4) == '/src' ? substr($folder, 0, -4) : $folder;

            if (file_exists($folder . '/data/assets')) {
                $output->writeln('Adding assets from ' . $moduleName . ' module..');
                $this->booty->addAssetsFolder($moduleName, $folder . '/data/assets');
            }
        }
        $output->writeln('Deploying assets to ' . $this->destination);
        $this->booty->deployAssets();

        return 0;
    }
}