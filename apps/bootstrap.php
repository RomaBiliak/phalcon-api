<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Application;
error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/apps');
define('SECURITY_PATH', APP_PATH . '/security');
//define('VENDOR_DIR' ,dirname(dirname(__FILE__))."/vendor");
try {

    /**
     * The FactoryDefault Dependency Injector automatically registers the services that
     * provide a full stack framework. These default services can be overidden with custom ones.
     */
    $di = new FactoryDefault();

    /**
     * Include general services
     */
    require APP_PATH . '/config/services.php';

    /**
     * Include vendor
     */
    require BASE_PATH . "../vendor/autoload.php";

    /**
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    /**
     * Include Autoloader
     */
    //include APP_PATH . '/config/loader.php';

    /**
     * Handle the request
     */
    $application = new Application($di);

    /**
     * Register application modules
     */
    $application->registerModules([
        'frontend' => [
                'className' => 'Apps\Modules\Frontend\Module',
                'path'      => '../apps/modules/frontend/Module.php'
            ],
            'establishment'  => [
                'className' => 'Apps\Modules\Establishment\Module',
                'path'      => '../apps/modules/establishment/Module.php'
            ]
    ]);
		
    /**
     * Include routes
     */
    require APP_PATH . '/config/routes.php';
	
	
    echo str_replace(["\n","\r","\t"], '', $application->handle()->getContent());

} catch (\Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
