<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitff7b00c5b5e29809ee1d5ca4db251fac
{
    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInitff7b00c5b5e29809ee1d5ca4db251fac::$classMap;

        }, null, ClassLoader::class);
    }
}
