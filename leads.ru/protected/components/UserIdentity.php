<?php

/**
 * Class UserIdentity
 */
class UserIdentity extends CUserIdentity
{
    protected $_id;
    protected $_name;
    protected $_email;
    protected $_role;

    public function authenticate()
    {
        $user = Users::model()->find('`status`=' . Users::USER_STATUS_CONFIRMED . ' AND LOWER(email)=?', [strtolower($this->username)]);

        if (($user === null) || (Users::cryptPassword($this->password) !== $user->password && $this->code != $user->code)) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else {
            $this->_id = $user->id;

            $this->_email = $user->email;

            $this->_role = $user->role;

            $this->errorCode = self::ERROR_NONE;
        }
        return !$this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getEmail()
    {
        return $this->_email;
    }

    public function getRole()
    {
        return $this->_role;
    }
}
