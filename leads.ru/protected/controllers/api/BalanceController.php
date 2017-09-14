<?php

/**
 * Class BalanceController
 */
class BalanceController extends AbstractApiController
{
    const OPERATION_ERROR = 'Insufficient funds';
    const OPERATION_OK = 'Successful';

    public function actionIndex()
    {
        $modelUser = $this->_requireAuth();
        $modelBonus = UsersBonus::model()->findByAttributes(['user_id' => $modelUser->id]);
        $bonus = Yii::app()->request->getPost('bonus', 0);
        $status = self::OPERATION_ERROR;
        if ($modelBonus->bonus >= $bonus) {
            $status = self::OPERATION_OK;
            $modelBonus->bonus -= $bonus;
            if(!$modelBonus->save()){
                $this->_sendResponse($this::CODE_RESPONSE_OTHER_ERROR, CJSON::encode([
                    'message' => 'Ошибка записи в БД',
                    'errors' => $modelBonus->getErrorsOneString()
                ]));
            }
        }

        $this->_sendResponse($this::CODE_RESPONSE_SUCCESS, CJSON::encode(
            [
                'status' => $status,
                'models' => $modelBonus
            ]
        ));
    }





}
