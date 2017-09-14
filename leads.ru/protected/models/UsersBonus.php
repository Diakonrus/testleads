<?php

/**
 * Class UsersBonus
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $bonus
 * @property string $updated_at
 * @property string $created_at
 *
 * @property Users[] $user
 */
class UsersBonus extends ActiveRecord
{
    /**
     * @return string
     */
    public function tableName()
    {
        return 'users_bonus';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['user_id, bonus', 'required'],
            ['user_id', 'exist', 'attributeName' => 'id', 'className' => 'Users'],
            ['bonus', 'numerical', 'integerOnly' => true],
            ['updated_at, created_at', 'safe'],
            ['id, user_id, bonus, updated_at, created_at', 'safe', 'on' => 'search'],
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
            'alias' => 'users_bonus',
        ];
    }

    /**
     * @return array
     */
    public function relations()
    {
        return [
            'user' => [self::BELONGS_TO, 'Users', 'user_id'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'Пользователь',
            'bonus' => 'Бонус',
            'updated_at' => 'Дата редактирования',
            'created_at' => 'Дата создания'
        ];
    }

    /**
     * @return CActiveDataProvider
     */
    public function search($param=array())
    {
        $criteria = $this->getDbCriteria();
        $criteria->compare('id', $this->id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('bonus', $this->bonus);
        $criteria->compare('updated_at', $this->updated_at, true);
        $criteria->compare('created_at', $this->created_at, true);

        return new CActiveDataProvider($this, ['criteria' => $criteria]);
    }

    /**
     * @param string $className
     * @return UsersBonus
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
