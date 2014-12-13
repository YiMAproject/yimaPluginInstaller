<?php

namespace YimaInstaller\Composer;

use Composer\Installer\LibraryInstaller;
use Composer\Package\PackageInterface;

/**
 * Class ComposerInstaller
 *
 * @package YimaInstaller\Composer
 */
class ComposerInstaller extends LibraryInstaller
{
    /**
     * {@inheritDoc}
     */
    public function getPackageBasePath(PackageInterface $package)
    {
        $yimaConstsFile = getcwd().DIRECTORY_SEPARATOR.'index.consist.php';
        if (!file_exists($yimaConstsFile))
            // we are not on YiMa
            return parent::getPackageBasePath($package);

        include_once $yimaConstsFile;

        list($namespace ,$packageName) = explode('/', $package->getPrettyName());

        // leave namespaces be
        $packageExtra = $package->getExtra();
        if (isset($packageExtra['yima-plugin-name'])) {
            $packageName = $packageExtra['yima-plugin-name'];
        }

        // determine directory by type
        // $package->getType()

        return APP_DIR_CORE.DS.$packageName;
    }

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        return "yima-core-module" === $packageType;
    }
}
