<?php
/**
 * Class ActiveRecord
 */
class ActiveRecord extends CActiveRecord
{
    /** @var string */
    public $returnUrl;

    /** @var array */
    protected $_files = [];

    /** @return array */
    public function rules()
    {
        return [
            ['returnUrl', 'length', 'max' => 512],
        ];
    }

    /**
     * @param $limit
     * @return $this
     */
    public function limit($limit)
    {
        $this->getDbCriteria()->mergeWith([
            'limit' => $limit,
        ]);
        return $this;
    }

    /**
     * при поиске добавляет условие ATTR != VALUE
     * @param array $params
     * @return $this
     */
    public function not(array $params)
    {
        if (!is_array($params)) {
            return $this;
        }

        foreach ($params as $key => $value) {

            if (!in_array($key, $this->attributeNames()) || is_null($value)) continue;

            $this->getDbCriteria()->mergeWith(array(
                'condition' => '`' . $key . '` != :'.$key.'value',
                'params' => array($key.'value' => $value),
            ));
        }
        return $this;
    }

    /**
     * при поиске добавляет условие ATTR = VALUE
     * @param array $params
     * @return $this
     */
    public function is(array $params)
    {
        if (!is_array($params)) {
            return $this;
        }

        foreach ($params as $key => $value) {

            if (!in_array($key, $this->attributeNames()) || is_null($value)) continue;

            $this->getDbCriteria()->mergeWith(array(
                'condition' => '`' . $key . '` = :'.$key.'value',
                'params' => array($key.'value' => $value),
            ));
        }
        return $this;
    }

    /**
     * при поиске добавляет условие ATTR in ARRAY
     * @param array $params
     * @return $this
     */
    public function inArray(array $params)
    {
        if (!is_array($params) || empty($params)) {
            return $this;
        }

        foreach ($params as $key => $value) {

            if (!in_array($key, $this->attributeNames())) continue;

            $criteria = $this->getDbCriteria();
            $criteria->addInCondition($key, is_array($value) ? $value : [$value]);
            $this->setDbCriteria($criteria);
        }
        return $this;
    }

    /**
     * при поиске добавляет условие ATTR !in ARRAY
     * @param array $params
     * @return $this
     */
    public function notInArray(array $params)
    {
        if (!is_array($params)) {
            return $this;
        }

        foreach ($params as $key => $value) {

            if (!in_array($key, $this->attributeNames()) || !is_array($value)) continue;

            $criteria = $this->getDbCriteria();
            $criteria->addNotInCondition($key, $value);
            $this->setDbCriteria($criteria);
        }
        return $this;
    }

    /**
     * @param $attr
     * @param $value
     * @return $this
     */
    public function setAttr($attr, $value)
    {
        if (in_array($attr, $this->attributeNames())) {
            $this->$attr = $value;
        }
        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setScenario($value)
    {
        parent::setScenario($value);
        return $this;
    }

    /**
     * @param string $dir
     * @return ActiveRecord
     */
    protected function prepareDir($dir)
    {
        @mkdir('uploads/');
        @chmod('uploads/', 0777);
        @mkdir($dir);
        @chmod($dir, 0777);

        return $this;
    }

    /**
     * @return bool
     */
    protected function beforeSave()
    {
        $this->updated_at = new CDbExpression('NOW()');

        if ($this->isNewRecord) {
            $this->created_at = $this->updated_at;
        }

        return parent::beforeSave();
    }

    /**
     * @return array
     */
    public function getErrorsOneString()
    {
        $errors = [];
        foreach($this->getErrors() as $field => $messages)
        {
            $errors[$field] = implode(' | ', $messages);
        }
        return $errors;
    }
}
