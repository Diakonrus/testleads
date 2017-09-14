<?php

class SiteController extends Controller
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
        $model = null;
        $this->render('index', ['model' => $model]);
    }

    /**
     *
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if (Yii::app()->request->getPost('ajax') === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (Yii::app()->request->getIsPostRequest()) {
            $model->attributes = Yii::app()->request->getPost('LoginForm');
            if ($model->validate() && $model->login()) {
                $this->redirect('/profile');
            }
        }

        $this->render('login', ['model' => $model]);
    }

    public function actionRegistration()
    {
        $model = new RegistrationForm();
        if (Yii::app()->request->getIsPostRequest()) {
            $model->attributes = Yii::app()->request->getPost('RegistrationForm');
            if ($model->validate()) {
                $modelUser = new Users();
                $modelUser->attributes = $model->attributes;
                $modelUser->password = Users::cryptPassword($model->password);
                $modelUser->role = Users::ROLE_USER;
                $modelUser->status = Users::USER_STATUS_NEW;
                if ($modelUser->save()) {
                    $this->sendConfirm($modelUser);
                    $this->redirect('/registrationSuccess');
                }
            }
        }

        $this->render('registration', ['model' => $model]);
    }

    /**
     * @return void
     */
    public function actionRegistrationSuccess()
    {
        $this->render('registrationSuccess');
    }

    /**
     * @param $code
     */
    public function actionRegistrationConfirm($code)
    {
        $modelUser = Users::model()->findByAttributes(['code' => $code]);
        if ($modelUser) {
            $modelUser->status = Users::USER_STATUS_CONFIRMED;
            $modelUser->update();
            $model = new LoginForm();
            $model->email = $modelUser->email;
            $model->password = $modelUser->password;
            $model->code = $modelUser->code;

            if ($model->login()) {
                $this->redirect('/profile');
            }
        }

        $this->redirect('/registration');
    }

    /**
     * @return void
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('error', $error);
            }
        }
    }


    /**
     * @return false
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect('/');
    }

    /**
     * Sends a e-mail to the user and charges a welcome bonus
     *
     * @param Users $modelUser
     */
    private function sendConfirm(Users $modelUser)
    {
        $modelBonus = UsersBonus::model()->findByAttributes(['user_id' => $modelUser->id]);
        if (!$modelBonus) {
            $modelBonus = new UsersBonus();
        }
        $modelBonus->user_id = $modelUser->id;
        $modelBonus->bonus += Yii::app()->params->welcomeBonus;
        if ($modelBonus->save()) {
            $subject = Yii::app()->params->mailTitle;
            $body = $this->renderPartial('registrationMail', ['model' => $modelUser]);
            Yii::app()->mailer->send([
                'email' => $modelUser->email,
                'subject' => $subject,
                'body' => $body
            ]);
        }
    }
}
