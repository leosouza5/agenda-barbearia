<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit396a4d21a25b76da89c3fd2cd9d0ee1e
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInit396a4d21a25b76da89c3fd2cd9d0ee1e', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit396a4d21a25b76da89c3fd2cd9d0ee1e', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit396a4d21a25b76da89c3fd2cd9d0ee1e::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
