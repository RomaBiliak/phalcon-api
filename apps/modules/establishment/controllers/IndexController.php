<?php
namespace Apps\Modules\Establishment\Controllers;

use Phalcon\Mvc\Controller;
use Apps\Common\Models\Users;
//use Apps\Modules\Establishment\Models\Users;
use Phalcon\Mvc\Model\Query;

class IndexController extends Controller
{
    public function indexAction()
    {

        /*$test = Users::query()
        ->where('id >0')
        ->order('phone')
        ->execute();
        var_dump($test);die;*/

        try{
           $query = $this->modelsManager->createQuery('SELECT * FROM Apps\Common\Models\Users');
           $test = $query->execute();
			var_dump($test);die;

       } catch (\Exception $e) {
	       $debug = new \Phalcon\Debug();
	       die($debug->listen()->onUncaughtException($e));
       }


       var_dump(Users::find());
	   echo 'Establishment';
	   // return $this->response->forward('login');
    }
}
