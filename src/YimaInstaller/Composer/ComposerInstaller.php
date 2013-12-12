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
        $strlen = strlen('yima-');
        $prefix = substr($package->getPrettyName(), 0, $strlen);
        if ('yima-' !== $prefix) {
            throw new \InvalidArgumentException(sprintf(
                'Unable to install package "%s"'
                .'should always start their package name with '
                .'"yima-", package start with "%s"',
                $package->getPrettyName(),
                $prefix
                )
            );
        }

        $packageName = str_replace(' ', '', ucwords(str_replace('-', ' ', substr($package->getPrettyName(), $strlen))));

        return '_app/core/'.$packageName;
    }

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        return "yima-core-module" === $packageType;
    }
}
