<?php


namespace V_Corp\base\models;

use V_Corp\base\db\ModelMysqli;


class Model extends ModelMysqli
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
        if ($this->id) {
            return $this->update();
        } else {
            return $this->insert();
        }
    }

}