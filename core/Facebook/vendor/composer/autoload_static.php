<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitfeb4419a08ad4400eb0d00b776bcd121
{
    public static $files = array (
        'c65d09b6820da036953a371c8c73a9b1' => __DIR__ . '/..' . '/facebook/graph-sdk/src/Facebook/polyfills.php',
    );

    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Facebook\\' => 9,
            'FacebookAds\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Facebook\\' => 
        array (
            0 => __DIR__ . '/..' . '/facebook/graph-sdk/src/Facebook',
        ),
        'FacebookAds\\' => 
        array (
            0 => __DIR__ . '/..' . '/facebook/php-ads-sdk/src/FacebookAds',
            1 => __DIR__ . '/..' . '/facebook/php-business-sdk/src/FacebookAds',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitfeb4419a08ad4400eb0d00b776bcd121::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitfeb4419a08ad4400eb0d00b776bcd121::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
