<?php

/**
 * Class AbstractApiController
 */
abstract class AbstractApiController extends CController
{

    /**
     * version API
     */
    const VERSION_API = 1.00;

    /**
     * Customer response codes
     */
    const CODE_RESPONSE_SUCCESS = 200;
    const CODE_RESPONSE_BAD_REQUEST = 400;
    const CODE_RESPONSE_UNAUTH = 401;
    const CODE_RESPONSE_NO_AUTH = 403;
    const CODE_RESPONSE_OTHER_ERROR = 404;
    const CODE_RESPONSE_SERVER_ERROR = 500;
    const CODE_RESPONSE_NOT_IMP = 501;
    const CODE_RESPONSE_ERROR_BD = 700;

    /**
     * @param $status
     * @return string
     */
    private $errorResponseCodes = [
        self::CODE_RESPONSE_SUCCESS => 'OK',
        self::CODE_RESPONSE_BAD_REQUEST => 'Bad Request',
        self::CODE_RESPONSE_UNAUTH => 'Unauthorized',
        self::CODE_RESPONSE_NO_AUTH => 'Forbidden',
        self::CODE_RESPONSE_OTHER_ERROR => 'Not Found',
        self::CODE_RESPONSE_SERVER_ERROR => 'Internal Server Error',
        self::CODE_RESPONSE_NOT_IMP => 'Not Implemented',
        self::CODE_RESPONSE_ERROR_BD => 'Error save to BD',
    ];



    public function __construct($id, $module)
    {
        parent::__construct($id, $module);
    }


    /**
     * @return null
     */
    private function  getCodeHeaders()
    {
        $headers = getallheaders();
        return !empty($headers['code']) ? $headers['code'] : null;
    }

    /**
     * @return Users
     */
    protected function _requireAuth()
    {
        $code = $this->getCodeHeaders();
        $user = Users::model()->findByAttributes(['code' => $code]);
        if (!$user) {
            $this->_sendResponse($this::CODE_RESPONSE_NO_AUTH, CJSON::encode(['Invalid code!']));
        }
        return $user;
    }

    /**
     * @param int $status
     * @param string $body
     * @param string $content_type
     */
    protected function _sendResponse($status = self::CODE_RESPONSE_SUCCESS, $body = '', $content_type = 'application/json')
    {
        header('HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status));
        header('Content-type: ' . $content_type);
        header('Api-version: ' . $this::VERSION_API);
        echo $body;
        Yii::app()->end();
    }


    /**
     * @param $status
     * @return mixed|string
     */
    private function _getStatusCodeMessage($status)
    {
        $codes = $this->errorResponseCodes;
        return (isset($codes[$status])) ? $codes[$status] : '';
    }

    /**
     * @return array
     */
    public function returnStatusCode(){
        return $this->errorResponseCodes;
    }
}
