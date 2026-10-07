<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DATABASE_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            // 'encrypt' => env('DB_ENCRYPT', 'yes'),
            // 'trust_server_certificate' => env('DB_TRUST_SERVER_CERTIFICATE', 'false'),
        ],




        'oracle' => [
            'driver'         => 'oracle',
            'tns'            => env('DB_TNS', ''),
            'host'           => env('DB_HOST', ''),
            'port'           => env('DB_PORT', '1521'),
            'database'       => env('DB_DATABASE', ''),
            'service_name'   => env('DB_SERVICE_NAME', ''),
            'username'       => env('DB_USERNAME', ''),
            'password'       => env('DB_PASSWORD', ''),
            'charset'        => env('DB_CHARSET', 'AL32UTF8'),
            'prefix'         => env('DB_PREFIX', ''),
            'prefix_schema'  => env('DB_SCHEMA_PREFIX', ''),
            'edition'        => env('DB_EDITION', 'ora$base'),
            'server_version' => env('DB_SERVER_VERSION', '11g'),
            'load_balance'   => env('DB_LOAD_BALANCE', 'yes'),
            'dynamic'        => [],
        ],



###########################BIOMETRIE#################################




        // <-- Ajoute ta connexion externe ici
'mysql_sigfae' => [
    'driver' => 'mysql',
    'host' => env('DB_SIGFAE_HOST', '10.101.101.106'),
    'port' => env('DB_SIGFAE_PORT', '3306'),
    'database' => env('DB_SIGFAE_DB', 'dba_mfprasitepro'),
    'username' => env('DB_SIGFAE_USER', 'cockpit'),
    'password' => env('DB_SIGFAE_PASSWORD', 'c033@ndeR'),
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
    'strict' => false,
    'engine' => null,
],



'mssql_biometrie' => [
    'driver' => 'sqlsrv',
    'host' => env('DB_BIOMETRIE_HOST'),
    'port' => env('DB_BIOMETRIE_PORT'),
    'database' => env('DB_BIOMETRIE_DB'),
    'username' => env('DB_BIOMETRIE_USER'),
    'password' => env('DB_BIOMETRIE_PASSWORD'),
    'charset' => 'utf8',
    'prefix' => '',
    'trust_server_certificate' => true,
],

/* 'connexion_oracl' => [
    'driver'       => 'oracle',
    'tns'          => '',                  // vide si tu utilises host+port+service_name
    'host'         => env('DB_ORACLE_HOST', '192.168.6.37'),
    'port'         => env('DB_ORACLE_PORT', '1521'),
    'database'     => '',                  // <-- mettre vide si service_name est utilisé
    'service_name' => env('DB_ORACLE_SERVICE', 'dbmfpe.mfp.ci'),
    'username'     => env('DB_ORACLE_USERNAME', 'UT_SIGNATURE'),
    'password'     => env('DB_ORACLE_PASSWORD', 'uSIGNATURE'),
    'charset'      => 'AL32UTF8',
    'prefix'       => '',
],
 */

'connexion_oracl' => [
    'driver'   => 'oracle',
    'tns'      => '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=192.168.6.37)(PORT=1521))(CONNECT_DATA=(SERVICE_NAME=dbmfpe.mfp.ci)))',
    'database' => 'dbmfpe.mfp.ci', // obligatoire
    'username' => env('DB_ORACLE_USERNAME', 'UT_SIGNATURE'),
    'password' => env('DB_ORACLE_PASSWORD', 'uSIGNATURE'),
    'charset'  => 'AL32UTF8',
    'prefix'   => '',
],

















######################################################################





















    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],

];
