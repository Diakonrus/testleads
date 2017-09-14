<?php

class UserController extends Controller
{
    /**
     * @var
     */
    public $layout;

    /**
     * @return array
     */
    public function actions()
    {
        $this->layout = '//layouts/main';
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }


    /**
     * @return void
     */
    public function actionIndex()
    {
        $model = UsersBonus::model()->findByAttributes(['user_id' => Yii::app()->user->id]);
        $modelUser = $model->user;

        if (Yii::app()->request->getIsPostRequest()) {
            $modelUser->attributes = Yii::app()->request->getPost('Users');
            $modelUser->save();
        }


        $this->render('profile', ['model' => $model, 'modelUser' => $modelUser]);
    }
}
