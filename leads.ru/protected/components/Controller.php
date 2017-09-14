<?php
/**
 * Class Controller
 */
class Controller extends CController
{
    /** @var string */
    public $layout='//layouts/dynamic';

    /** @var array */
    public $breadcrumbs = [];

    /** @var array  */
    public $menu = [];

    /** @var string  */
    public $menuTitle = 'Сайдбар';

    /** @var int */
    public $topMenuActive = 0;

    /**
     * @return array
     */
    public function getTopMenu()
    {
        return [
            ['label'=>'Профиль', 'url' => ['/profile'], 'visible' => ! Yii::app()->user->isGuest],
            ['label'=>'Вход', 'url' => ['/login'], 'visible' => Yii::app()->user->isGuest],
            ['label'=>'Выход ('.Yii::app()->user->email.')', 'url' => ['/logout'], 'visible' => !Yii::app()->user->isGuest]
        ];
    }

    /**
     * @return array
     */
    public function filters()
    {
        return array('AccessControl');
    }

    /**
     * @param CFilterChain $filterChain
     */
    public function filterAccessControl($filterChain)
    {
        $rules      = $this->accessRules();
        $controller = $filterChain->controller;
        $controller = $controller ? $controller->getId() : null;
        $rules[]    = (!Yii::app()->user->isGuest || (in_array($controller, ['site']))) ? ['allow'] : ['deny'];

        $filter = new CAccessControlFilter;
        $filter->setRules($rules);
        $filter->filter($filterChain);
    }

    public function chkAccess($role_name){
        if(!Yii::app()->user->checkAccess($role_name)){
            throw new CHttpException(403,'У вас нет прав для доступа к этой странице');
        }
    }
}
