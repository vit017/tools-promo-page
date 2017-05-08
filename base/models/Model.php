<?php


namespace V_Corp\base\models;

use V_Corp\base\db\MysqliModel;


class Model extends MysqliModel
{

    public function validate() {
        return true;
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
        if ($this->{$this->primaryKey}) {
            return $this->update();
        } else {
            return $this->insert();
        }
    }

}