<?php

namespace Apps\Modules\Establishment;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\Dispatcher;
use Phalcon\DiInterface;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Db\Adapter\Pdo\Postgresql as Database;
use Phalcon\Translate\Factory;
use Phalcon\Events\Manager as EventsManager;
use Apps\Common\Service\TranslateService;
use Apps\Common\Service\Response\Response;
use Apps\Common\Service\JwtService;
use Apps\Common\Plugin\SecurityPlugin;
use Apps\Modules\Establishment\Service\EstablishmentService;

class Module implements ModuleDefinitionInterface
{
    /**
     * Registers the module auto-loader
     *
     * @param DiInterface $di
     */
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();
        $loader->registerNamespaces(
            [
                'Apps\Modules\Establishment\Controllers' =>  __DIR__ . '/controllers/',
                'Apps\Modules\Establishment\Models'      =>  __DIR__ . '/models/',
                'Apps\Modules\Establishment\Validation'      =>  __DIR__ . '/validation/',
                'Apps\Modules\Establishment\Exceptions'      =>  __DIR__ . '/exceptions/',
                'Apps\Modules\Establishment\Service'      =>  __DIR__ . '/service/',
                'Apps\Common\Service' => APP_PATH . '/common/service/',
                'Apps\Common\Helper' => APP_PATH . '/common/helper/',
                'Apps\Common\Exceptions' => APP_PATH . '/common/exceptions/',
                'Apps\Common\Plugin' => APP_PATH . '/common/plugin/',
            ]
        );
        $loader->register();

    }

    /**
     * Registers services related to the module
     *
     * @param DiInterface $di
     */
    public function registerServices(DiInterface $di)
    {
        $di->setShared('locale', function () use ($di){
            $locale = new TranslateService(__DIR__ . '/translate/');
            return $locale->getTranslation() ;
        });


        $di->setShared('JWT', function () {
            $jwt = new JwtService([
                'key'=>'qw25wee2qwvr'
            ]);
            return $jwt ;
        });
        $di->setShared('establishment', function () {
            $establishment = new EstablishmentService();
            return $establishment ;
        });
		$di->setShared(
		  'api_response',
		  function () {
			  $response = new  Response();
			  $response->setContentType('application/json', 'utf-8');
			  return $response;
		  }
		);
		$di->setShared(
		  'response',
		  function () {
			  $response = new \Phalcon\Http\Response();
			  $response->setContentType('application/json', 'utf-8');

			  return $response;
		  }
		);
	




        // Registering a dispatcher
        $di->set('dispatcher', function () {

            $eventsManager = new EventsManager();

            $eventsManager->attach(
                "dispatch:beforeExecuteRoute",
                new SecurityPlugin()
            );

            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace('Apps\Modules\Establishment\Controllers\\');
            $dispatcher->setEventsManager($eventsManager);


            return $dispatcher;
        });


        // Registering the view component
         $di->set('view', function () {
            $view = new View();
            $view->setDI($this);
            $view->setViewsDir(__DIR__ . '/views/');

            return $view;
        });

        // Set a different connection in each module
        $di->set('db', function () {
            return new Database(
                [
					"host" => "localhost",
                    "username" => "postgres",
                    "password" => "",
                    "dbname" => "phalcon"
                ]
            );
        });
    }
}
