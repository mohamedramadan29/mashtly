<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitdb7be0b0ff960bc34da12fc3056b02bc
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'Automattic\\WooCommerce\\' => 23,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Automattic\\WooCommerce\\' => 
        array (
            0 => __DIR__ . '/..' . '/automattic/woocommerce/src/WooCommerce',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitdb7be0b0ff960bc34da12fc3056b02bc::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitdb7be0b0ff960bc34da12fc3056b02bc::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}