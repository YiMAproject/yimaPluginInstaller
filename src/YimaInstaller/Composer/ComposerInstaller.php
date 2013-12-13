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
        list($namespace ,$packageName) = explode('/', $package->getPrettyName());

        // leave namespace free

        $strlen = strlen('yima-');
        $prefix = substr($packageName, 0, $strlen);
        if ($prefix !== 'yima-') {
            throw new \InvalidArgumentException(sprintf(
                'Unable to install package "%s"'
                .'should always start their package name with '
                .'"yima-", package start with "%s"',
                $packageName,
                $prefix
                )
            );
        }

        $packageName = str_replace(' ', '', ucwords(str_replace('-', ' ', substr($packageName, $strlen))));

        require_once getcwd().DIRECTORY_SEPARATOR.'indefine.php';

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
