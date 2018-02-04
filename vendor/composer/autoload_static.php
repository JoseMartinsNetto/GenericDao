<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitea1249c7fab8ec80bad666b60c252bda
{
    public static $prefixLengthsPsr4 = array (
        'G' => 
        array (
            'GenericDao\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'GenericDao\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitea1249c7fab8ec80bad666b60c252bda::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitea1249c7fab8ec80bad666b60c252bda::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}