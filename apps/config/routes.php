<?php
use Phalcon\Mvc\Router;
use Phalcon\Mvc\Router\Group as RouterGroup;
use \Phalcon\Mvc\Router\Group\Hostname;


$di->setShared('router', function () {
    $router = new Router();

    $router->setDefaultModule('frontend');
	
    return $router;
});

$router = $di->getRouter();



$router->add('/:controller/:action', [
	'module'     => 'frontend',
	'controller' => 1,
	'action'     => 2,
])->setName('frontend');

$router->add("/login", [
	'module'     => 'Establishment',
	'controller' => 'login',
	'action'     => 'index',
])->setName('establishment-login');



/////////////////////////////////////establishment///////////////////////////////////////////////


$establishment = new RouterGroup(
	[
		"module" => "establishment",
		"controller" => "index",
		'action'     => 'index',
	]
);

$establishment->setPrefix("/establishment");


$establishment->addGet("/", [
	'controller' => 'index',
	'action'     => 'index',
])->setName('establishment');
$establishment->addPost("/login", [
	'controller' => 'login',
	'action'     => 'login',
])->setName('establishment-login');


$establishment->addGet("/personal-data", [
	'controller' => 'personal',
	'action'     => 'getPersonalData',
])->setName('personal');
$establishment->addPost("/personal-data", [
    'controller' => 'personal',
    'action'     => 'addPersonalData',
])->setName('add-personal');
$establishment->addPut("/personal-data", [
    'controller' => 'personal',
    'action'     => 'editPersonalData',
])->setName('edit-personal');


$establishment->addGet("/scheme-hall", [
	'controller' => 'scheme',
	'action'     => 'getSheme',
])->setName('get-scheme-hall');
$establishment->addPost("/scheme-hall", [
    'controller' => 'scheme',
    'action'     => 'addSheme',
])->setName('add-scheme-hall');
$establishment->addPut("/scheme-hall", [
    'controller' => 'scheme',
    'action'     => 'editSheme',
])->setName('edit-scheme-hall');
$establishment->addDelete("/scheme-hall", [
    'controller' => 'scheme',
    'action'     => 'deleteSheme',
])->setName('delete-scheme-hall');

$establishment->addGet("/menu", [
	'controller' => 'menu',
	'action'     => 'getMenu',
])->setName('get-menu');
$establishment->addPost("/menu", [
    'controller' => 'menu',
    'action'     => 'addMenu',
])->setName('add-menu');
$establishment->addPut("/menu", [
    'controller' => 'menu',
    'action'     => 'editMenu',
])->setName('edit-menu');
$establishment->addDelete("/menu", [
    'controller' => 'menu',
    'action'     => 'deleteMenu',
])->setName('delete-menu');


$establishment->addGet("/admin-hall", [
    'controller' => 'adminHall',
    'action'     => 'getAdmin',
])->setName('get-menu');
$establishment->addGet("/admin-hall", [
    'controller' => 'adminHall',
    'action'     => 'getAdmins',
])->setName('get-menu');
$establishment->addPost("/admin-hall", [
    'controller' => 'adminHall',
    'action'     => 'addAdmin',
])->setName('add-menu');
$establishment->addPut("/admin-hall", [
    'controller' => 'adminHall',
    'action'     => 'editAdmin',
])->setName('edit-menu');
$establishment->addDelete("/admin-hall", [
    'controller' => 'adminHall',
    'action'     => 'deleteAdmin',
])->setName('delete-menu');



$router->mount($establishment);



