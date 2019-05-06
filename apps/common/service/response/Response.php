<?php
declare(strict_types=1);
namespace Apps\Common\Service\Response;

use Phalcon\Http\Response as PhalconResponse;
use Apps\Common\Service\Response\HttpStatusCodes;
/**
 * Class Response
 * @author Adeyemi Olaoye <yemi@cottacush.com>
 */
class Response extends PhalconResponse
{
    const RESPONSE_TYPE_ERROR = 'error';
    const RESPONSE_TYPE_SUCCESS = 'success';
    const RESPONSE_TYPE_FAIL = 'fail';

    public function __construct($content = null, $code = null, $status = null)
    {
        parent::__construct($content, $code, $status);
    }

    /**
     * @author Adeyemi Olaoye <yemi@cottacush.com>
     * @param int|string $http_status_code
     * @param null $message
     * @return mixed
     */
    public function sendError($http_status_code = 500, $message = null):void
    {
        $response = array(
            'status' => self::RESPONSE_TYPE_ERROR,
            'message' => (($message=='')) ? HttpStatusCodes::getMessage($http_status_code) : $message,
            'code' => $http_status_code
        );

        $this->setStatusCode($http_status_code, HttpStatusCodes::getMessage($http_status_code))->sendHeaders();
        $this->setJsonContent($response);
        $this->sendResponse();
    }


    /**
     * @author Adeyemi Olaoye <yemi@cottacush.com>
     * @param $data
     * @return mixed
     */
    public function sendSuccess($http_status_code=200, $data = null):void
    {
        $this->setStatusCode($http_status_code, HttpStatusCodes::getMessage($http_status_code))->sendHeaders();
        $this->setJsonContent(array(
            'status' => self::RESPONSE_TYPE_SUCCESS,
            'data' => (is_null($data) ? '' : $data),
            'message' =>  HttpStatusCodes::getMessage($http_status_code),
			'code' => $http_status_code
    ));

        $this->sendResponse();
    }

    /**
     * @author Adeyemi Olaoye <yemi@cottacush.com>
     * @param $data
     * @param int|string $http_status_code
     * @return mixed|void
     */
    public function sendFail($http_status_code = 500, $data):void
    {
		$this->setStatusCode($http_status_code, HttpStatusCodes::getMessage($http_status_code))->sendHeaders();
        $this->setJsonContent(array(
            'status' => self::RESPONSE_TYPE_FAIL,
            'data' => (is_null($data) ? '' : $data),
            'message' =>  HttpStatusCodes::getMessage($http_status_code),
			'code' => $http_status_code
        ));

        $this->sendResponse();
    }

    /**
     * Send response
     * @author Adeyemi Olaoye <yemi@cottacush.com>
     */
    public function sendResponse():void
    {
        $this->setContentType("application/json");
        if (!$this->isSent()) {
            $this->send();
        }
    }
}
