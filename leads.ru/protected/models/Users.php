<?php

/**
 * Class Users
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $code
 * @property integer $status
 * @property string $role
 * @property string $updated_at
 * @property string $created_at
 */
class Users extends ActiveRecord
{
    const ROLE_ADMIN = 'administrator';
    const ROLE_USER = 'user';

    /**
     * @var array
     */
    public static $userRole = [
        self::ROLE_ADMIN => 'Администратор',
        self::ROLE_USER => 'Пользователь'
    ];


    const USER_STATUS_NEW = 0;
    const USER_STATUS_CONFIRMED = 1;

    /**
     * @var array
     */
    public static $userStatus = [
        self::USER_STATUS_NEW => 'Новый',
        self::USER_STATUS_CONFIRMED => 'Подтвержден'
    ];


    /**
     * @return string
     */
    public function tableName()
    {
        return 'users';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['password', 'required', 'on' => 'create'],
            ['email', 'email'],
            ['email', 'unique'],
            ['status', 'in', 'range' => array_keys(self::$userStatus)],
            ['role', 'in', 'range' => array_keys(self::$userRole)],
            ['code', 'length', 'max' => 100],
            ['email', 'length', 'max' => 150],
            ['password, name', 'length', 'max' => 250],
            ['updated_at, created_at', 'safe'],
            ['name, email, password, status, role, code, updated_at, created_at', 'safe'],
        ];
    }

    /**
     * @return array
     */
    public function scopes()
    {
        $scopes = parent::scopes();
        return $scopes;
    }

    /**
     * @return array
     */
    public function defaultScope()
    {
        return [
            'alias' => 'users',
        ];
    }

    /**
     * @return array
     */
    public function relations()
    {
        return [];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Имя пользователя',
            'email' => 'E-mail',
            'password' => 'Пароль',
            'role' => 'Роль',
            'status' => 'Статус',
            'code' => 'Персональный ключ',
            'updated_at' => 'Дата редактирования',
            'created_at' => 'Дата создания'
        );
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = $this->getDbCriteria();
        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('role', $this->role);
        $criteria->compare('status', $this->status);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('updated_at', $this->updated_at, true);
        $criteria->compare('created_at', $this->created_at, true);

        return new CActiveDataProvider($this, ['criteria' => $criteria]);
    }

    /**
     * @param string $className
     * @return Users
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return void
     */
    public function gencode()
    {
        $arrayChars = [
            'a','b','c','d','e','f',
            'g','h','i','j','k','l',
            'm','n','o','p','r','s',
            't','u','v','x','y','z',
            'A','B','C','D','E','F',
            'G','H','I','J','K','L',
            'M','N','O','P','R','S',
            'T','U','V','X','Y','Z',
            '1','2','3','4','5','6',
            '7','8','9','0'
        ];
        for($i = 0; $i < 10; $i++)
        {
            $index = rand(0, count($arrayChars) - 1);
            $this->code .= $arrayChars[$index];
        }
    }

    /**
     * Encrypts the password
     *
     * @param $password
     * @return string
     */
    public static function cryptPassword($password)
    {
        return crypt($password, substr($password, 0, 2));
    }


    /**
     * @return bool
     */
    protected function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->gencode();
        }

        return parent::beforeSave();
    }

    /**
     * @return bool
     *
     */
    public function beforeDelete()
    {
        return parent::beforeDelete();
    }

}
