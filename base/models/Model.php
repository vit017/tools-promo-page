<?php


namespace V_Corp\base\models;

use V_Corp\base\db\MysqliModel;


class Model extends MysqliModel
{

    protected $_errors = [];

    public function keys()
    {
        return array_keys($this->attributes());
    }

    public function values()
    {
        $res = [];
        foreach ($this->attributes() as $key => $val) {
            $res[] = $this->$key;
        }

        return $res;
    }

    public function addError($attr, $msg, $value = '')
    {
        $this->_errors[$attr] = $value ? $msg . ' - ' . $value : $msg;
    }

    public function getErrors()
    {
        return $this->_errors;
    }

    public function validate()
    {
        $rules = $this->rules();
        foreach ($rules as $attr => $rule) {
            if ($rule[0] && ('' === trim($this->$attr))) {
                $this->addError($attr, $attr . ' is required');
            } elseif ($rule[1] && !preg_match($rule[1], $this->$attr)) {
                $msg = $rule[2] ?: 'wrong value of field ' . $attr;
                $this->addError($attr, $msg);
            }
        }

        return !count($this->_errors);
    }

    public function load(array $input)
    {
        foreach ($input as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }

        return $this;
    }

    public static function insertAll(array $models) {
        foreach ($models as $i => $model) {
            if (!$model->validate()) {
                array_splice($models, $i, 1);
            }
            else {
                $model->beforeSave();
            }
        }

        return parent::insertAll($models);
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->beforeSave();
        if ($this->id) {
            return $this->update();
        } else {
            return $this->insert();
        }
    }

}