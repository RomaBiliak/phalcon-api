<?php
namespace Apps\Modules\Establishment\Controllers;
use Phalcon\Mvc\Controller;

use Apps\Modules\Establishment\Service\AdminHallService;
use Apps\Modules\Establishment\Exceptions\{ValidateException, NotFoundException};
class AdminHallController extends Controller
{
    protected $admin_hall;
    public function initialize()
    {
        $this->admin_hall = new AdminHallService();
    }

    public function getAdminsAction()
    {
        try{
            $admins = $this->admin_hall->getAdmins();
            $this->api_response->sendSuccess(200, $admins);
        }catch (NotContentException $e) {
            $this->api_response->sendSuccess(204);
        }catch (\Exception $e) {
            $this->api_response->sendError($e->getCode()?$e->getCode():500,$e->getMessage());
        }
    }
    public function addAdminAction()
    {
        try{
            $this->admin_hall->addAdmin();
            $this->api_response->sendSuccess(201);
        }catch (ValidateException $e) {
            $this->api_response->sendError(406, unserialize($e->getMessage()));
        }catch (\Exception $e) {
            $this->api_response->sendError($e->getCode()?$e->getCode():500,$e->getMessage());
        }
    }
    public function editAdminAction()
    {
        try{
            $this->admin_hall->editAdmin();
            $this->api_response->sendSuccess(200);
        }catch (NotFoundException $e) {
            $this->api_response->sendError(404);
        }catch (ValidateException $e) {
            $this->api_response->sendError(406, unserialize($e->getMessage()));
        }catch (\Exception $e) {
            $this->api_response->sendError($e->getCode()?$e->getCode():500,$e->getMessage());
        }
    }
    public function deleteAdminAction()
    {
        try{
            $this->admin_hall->deleteAdmin();
            $this->api_response->sendSuccess(200);
        }catch (NotFoundException $e) {
            $this->api_response->sendError(404);
        }catch (\Exception $e) {
            $this->api_response->sendError($e->getCode()?$e->getCode():500,$e->getMessage());
        }
    }

}
