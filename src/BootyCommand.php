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

        foreach ($this->packages as $packageName) {

            $packageName = strpos($packageName, '\\') === 0 ? $packageName : '\\' . $packageName;
            $package = new $packageName();

            if ($package instanceof AssetRegistrationInterface) {
                $output->writeln('Adding assets from ' . $packageName . '..');
                $paths = $package->getAssetFolders();
                $this->handleAssetFolders($paths);
            }
        }

        $output->writeln('Deploying assets to ' . $this->destination);
        $this->booty->deployAssets();

        return 0;
    }

    /**
     * @param array $paths
     */
    private function handleAssetFolders(array $paths): void
    {
        foreach ($paths as $key => $path) {
            $this->booty->addAssetsFolder($key, $path);
        }
    }
}
