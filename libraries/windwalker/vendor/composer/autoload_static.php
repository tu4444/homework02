<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit54207f625e2b24b9932bd02d0ef3c194
{
    public static $files = array (
        '5309a257854ca5cc9612aafe2e186e93' => __DIR__ . '/..' . '/windwalker/utilities/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'Windwalker\\Utilities\\' => 21,
            'Windwalker\\Test\\' => 16,
            'Windwalker\\String\\' => 18,
            'Windwalker\\Router\\' => 18,
            'Windwalker\\Registry\\' => 20,
            'Windwalker\\IO\\' => 14,
            'Windwalker\\Html\\' => 16,
            'Windwalker\\Filesystem\\' => 22,
            'Windwalker\\Environment\\' => 23,
            'Windwalker\\Dom\\' => 15,
            'Windwalker\\Data\\' => 16,
            'Windwalker\\DataMapper\\' => 22,
            'Windwalker\\Console\\' => 19,
            'Windwalker\\Compare\\' => 19,
            'Windwalker\\Cache\\' => 17,
            'Windwalker\\' => 11,
            'Whoops\\' => 7,
        ),
        'S' => 
        array (
            'Symfony\\Component\\Yaml\\' => 23,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Windwalker\\Utilities\\' => 
        array (
            0 => __DIR__ . '/..' . '/windwalker/utilities',
        ),
        'Windwalker\\Test\\' => 
        array (
            0 => __DIR__ . '/../..' . '/test',
            1 => __DIR__ . '/..' . '/windwalker/test',
        ),
        'Windwalker\\String\\' => 
        array (
            0 => __DIR__ . '/..' . '/windwalker/string',
        ),
        'Windwalker\\Router\\' => 
        array (
            0 => __DIR__ . '/..' . '/windwalker/router',
        ),
        'Windwalker\\Registry\\' => 
        array (
            0 => __DIR__ . '/..' . '/windwalker/registry',
        ),
        'Windwalker\\IO\\' => 
        array (
            0 => __DIR__ . '/..' . '/windwalker/io',
        ),
        'Windwalker\\Html\\' => 
        array (
            0 => __DIR__ . '/..' . '/windwalker/html',
        ),
        'Windwalker\\Filesystem\\' => 
        array (
            0 => __DIR__ . '/..' . '/windwalker/filesystem',
        ),
        'Windwalker\\Environment\\' => 
        array (
            0 => __DIR__ . '/..' . '/windwalker/environment',
        ),
        'Windwalker\\Dom\\' => 
        array (
            0 => __DIR__ . '/..' . '/windwalker/dom',
        ),
        'Windwalker\\Data\\' => 
        array (
            0 => __DIR__ . '/..' . '/windwalker/data',
        ),
        'Windwalker\\DataMapper\\' => 
        array (
            0 => __DIR__ . '/..' . '/windwalker/datamapper',
        ),
        'Windwalker\\Console\\' => 
        array (
            0 => __DIR__ . '/..' . '/windwalker/console',
        ),
        'Windwalker\\Compare\\' => 
        array (
            0 => __DIR__ . '/..' . '/windwalker/compare',
        ),
        'Windwalker\\Cache\\' => 
        array (
            0 => __DIR__ . '/..' . '/windwalker/cache',
        ),
        'Windwalker\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Whoops\\' => 
        array (
            0 => __DIR__ . '/..' . '/filp/whoops/src/Whoops',
        ),
        'Symfony\\Component\\Yaml\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/yaml',
        ),
    );

    public static $fallbackDirsPsr4 = array (
        0 => __DIR__ . '/../..' . '/../../cli/windwalker',
    );

    public static $fallbackDirsPsr0 = array (
        0 => __DIR__ . '/..' . '/asika/muse/src',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit54207f625e2b24b9932bd02d0ef3c194::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit54207f625e2b24b9932bd02d0ef3c194::$prefixDirsPsr4;
            $loader->fallbackDirsPsr4 = ComposerStaticInit54207f625e2b24b9932bd02d0ef3c194::$fallbackDirsPsr4;
            $loader->fallbackDirsPsr0 = ComposerStaticInit54207f625e2b24b9932bd02d0ef3c194::$fallbackDirsPsr0;

        }, null, ClassLoader::class);
    }
}
