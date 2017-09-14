<?php

class RegistrationForm extends CFormModel
{

    // Profile data
    public $email;
    public $name;

    // Password
    public $password;
    public $password_repeat;

    public function rules()
    {
        return [
            ['email, password', 'required', 'message' => 'Не заполнено поле "{attribute}"'],
            ['email', 'email', 'checkMX' => true, 'message' => '"{attribute}" не является верным адресом электронной почты.'],
            ['email', 'length', 'max' => 150, 'message' => '"{attribute}" заполнено неверно', 'tooLong' => 'значение не должно превышать {max} символов', 'tooShort' => 'значение не должно быть меньше {min} символов'],
            ['email', 'checkUnique', 'message' => 'Такой email уже существует в системе'],
            ['password', 'length', 'min' => 6, 'max' => 64, 'message' => '"{attribute}" заполнено неверно', 'tooLong' => 'Пароль должен быть не более {max} символов', 'tooShort' => 'Пароль должен быть не менее {min} символов'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Пожалуйста, повторите указанный пароль в "{attribute}" верно.'],
            ['name', 'length', 'max' => 250]
        ];
    }

    /**
     * @param $field
     * @param $data
     */
    public function checkUnique($field, $data)
    {
        if (!$this->getError($field)) {
            $model = Users::model()->find($field . '=?', [$this->$field]);
            if ($model) {
                $this->addError($field, $data['message']);
            }
        }
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Имя пользователя',
            'email' => 'E-mail',
            'password' => 'Пароль',
            'password_repeat' => 'Повторите пароль',
        ];
    }
}
