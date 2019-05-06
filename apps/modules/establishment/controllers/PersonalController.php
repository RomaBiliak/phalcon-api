<?php
declare(strict_types=1);
namespace Apps\Modules\Establishment\Controllers;
use Phalcon\Mvc\Controller;

use Apps\Modules\Establishment\Service\PersonalDataService;
use Apps\Modules\Establishment\Exceptions\{ValidateException};
use Apps\Common\Exceptions\{ NotFoundException};
class PersonalController extends Controller
{

    protected $personal_data;
    public function initialize()
    {
        $this->personal_data = new PersonalDataService();
    }
    public function getPersonalDataAction()
    {
        try{
            $establishment = $this->personal_data->getPersonalData();
            $this->api_response->sendSuccess(200, $establishment);
        }catch (NotFoundException $e) {
            $this->api_response->sendError(404);
        }catch (\Exception $e) {
            $this->api_response->sendError($e->getCode()?$e->getCode():500, $e->getMessage());
        }
    }
    public function addPersonalDataAction()
    {
        try{
            $this->personal_data->addPersonalData();
            $this->api_response->sendSuccess(201);
        }catch (ValidateException $e) {
            $this->api_response->sendError(406, unserialize($e->getMessage()));
        }catch (\Exception $e) {
            $this->api_response->sendError($e->getCode()?$e->getCode():500, $e->getMessage());
        }
    }

    public function editPersonalDataAction()
    {
        try{
            $establishment = $this->personal_data->editPersonalData();
            $this->api_response->sendSuccess(200, $establishment);
        }catch (NotFoundException $e) {
            $this->api_response->sendError(404);
        }catch (ValidateException $e) {
            $this->api_response->sendError(406, unserialize($e->getMessage()));
        }catch (\Exception $e) {
            $this->api_response->sendError($e->getCode()?$e->getCode():500, $e->getMessage());
        }
    }
}
