<?php


namespace V_Corp\base\models;


use V_Corp\base\db\Mysqli;

class ModelMysqli
{

    public static $defaultSort = 'id desc';

    public static function find(int $primary)
    {
        $query = 'SELECT * FROM ' . static::tableName() . ' WHERE `id`=' . $primary . ' LIMIT 1';
        $db_result = self::driver()->query($query);
        if (!$db_result->num_rows) {
            return null;
        }

        $model = new static();
        $model->load($db_result->fetch_assoc());
        $model->afterFind();

        return $model;
    }

    public static function findAll()
    {
        $query = 'SELECT * FROM ' . static::tableName() . ' ORDER BY '.static::$defaultSort;
        $db_result = self::driver()->query($query);
        if (!$db_result->num_rows) {
            return null;
        }

        $models = [];
        while ($row = $db_result->fetch_assoc()) {
            $model = new static();
            $models[] = $model->load($row);
            $model->afterFind();
        }

        return $models;
    }

    public function delete() {
        $query = 'DELETE FROM ' . static::tableName() . ' WHERE `id`='.$this->id;
        return self::driver()->query($query);
    }

    public function insert() {
        $keys = $this->keys();
        $values = $this->values();
        foreach ($keys as $i => $key) {
            $sKeys[] = '`'.$key.'`';
        }
        foreach ($values as $i => $value) {
            $sValues[] = '\''.$value.'\'';
        }
        $sKeys = implode(',', $sKeys);
        $sValues = implode(',', $sValues);

        $query = 'INSERT INTO `'.static::tableName().'` ('.$sKeys.') VALUES ('.$sValues.')';
        return self::driver()->query($query);
    }

    public function update() {
        $keys = $this->keys();
        $values = $this->values();
        $set = '';
        foreach ($keys as $i => $key) {
            $set[] = '`'.$key.'`'.'='.'\''.$values[$i].'\'';
        }
        $set = implode(',',$set);

        $query = 'UPDATE `'.static::tableName().'` SET '.$set.' WHERE `id` = '.$this->id;
        return self::driver()->query($query);
    }

    public function save() {
        $this->beforeSave();
        if ($this->id) {
            return $this->update();
        }
        else {
            return $this->insert();
        }
    }

    public static function driver()
    {
        return Mysqli::instance();
    }


}