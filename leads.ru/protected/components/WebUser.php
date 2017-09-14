<?php
/**
 * Class WebUser
 */
class WebUser extends CWebUser {
    private $_model = null;

    function getRole() {
        if($user = $this->getModel()){
            return $user->role;
        }
    }

    function getEmail(){
        if (!$this->isGuest){
            $this->_model = Users::model()->findByPk($this->id, ['select' => 'email']);
            return $this->_model->email;
        }
    }

    private function getModel(){
        if (!$this->isGuest && $this->_model === null){
            $this->_model = Users::model()->findByPk($this->id, ['select' => 'role']);
        }
        return $this->_model;
    }
}
