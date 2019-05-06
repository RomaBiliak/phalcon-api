<?php
/*
 * Modified: prepend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/apps');

return new \Phalcon\Config([
    'version' => '1.0',

    'database' => [
        'adapter'  => 'Postgres',
        'host'     => 'localhost',
        'username' => 'posgrest',
        'password' => '',
        'dbname'   => 'phalcon',
        'charset'  => 'utf8',
    ],


    'printNewLine' => true
]);
