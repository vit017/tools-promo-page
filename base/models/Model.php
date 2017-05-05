<?php


namespace V_Corp\base\models;

use V_Corp\base\db\ModelMysqli;


class Model extends ModelMysqli
{



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