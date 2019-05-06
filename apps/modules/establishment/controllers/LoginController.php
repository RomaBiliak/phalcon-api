<?php
declare(strict_types=1);
namespace Apps\Modules\Establishment\Controllers;
use Phalcon\Mvc\Controller;


use Apps\Modules\Establishment\Service\LoginService;
use Apps\Modules\Establishment\Exceptions\{ValidateException};
use Apps\Common\Exceptions\LoginException;
class loginController extends Controller
{

    protected $login;
    public function initialize()
    {
        $this->login = new LoginService();
    }
    public function loginAction()
    {
        try{
            $jwt = $this->login->login();
            $this->api_response->sendSuccess(200, ['tocken'=>$jwt]);
        }catch (ValidateException $e) {
            $this->api_response->sendError(406, unserialize($e->getMessage()));
        }catch (LoginException $e) {
            $this->api_response->sendError(401);
        }catch (\Exception $e) {
            $this->api_response->sendError($e->getCode()?$e->getCode():500, $e->getMessage());
        }
    }

}
