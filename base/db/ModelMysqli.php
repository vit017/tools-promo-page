<?php


namespace V_Corp\base\db;


use V_Corp\base\db\Mysqli;

class ModelMysqli
{

    public static $defaultSort = 'id desc';

    public static function find(int $primary)
    {
        $query = 'SELECT * FROM ' . static::tableName() . ' WHERE `id`=' . $primary . ' ORDER BY ' . static::$defaultSort . ' LIMIT 1';
        $db_result = self::driver()->query($query);
        if (!$db_result->num_rows) {
            return null;
        }

        $model = new static();
        $model->load($db_result->fetch_assoc());
        $model->afterFind();

        return $model;
    }

    public static function findByAttr($key, $val, $condition)
    {
        $where = '`' . $key . '`' . $condition . '\'' . $val . '\'';
        $query = 'SELECT * FROM ' . static::tableName() . ' WHERE ' . $where . ' ORDER BY ' . static::$defaultSort . ' LIMIT 1';
        $db_result = self::driver()->query($query);
        if (!$db_result->num_rows) {
            return null;
        }

        $model = new static();
        $model->load($db_result->fetch_assoc());
        $model->afterFind();

        return $model;
    }

    public static function findAllByAttr($key, $val, $condition)
    {
        $where = '`' . $key . '`' . $condition . '\'' . $val . '\'';
        $query = 'SELECT * FROM ' . static::tableName() . ' WHERE ' . $where . ' ORDER BY ' . static::$defaultSort;
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

    public static function findByAndCondition()
    {
        $args = func_get_args();
        foreach ($args as $i => $arg) {
            $where[] = '`' . $arg[0] . '`' . $arg[2] . '\'' . $arg[1] . '\'';
        }
        $sWhere = implode(' AND ', $where);

        $query = 'SELECT * FROM ' . static::tableName() . ' WHERE ' . $sWhere . ' ORDER BY ' . static::$defaultSort . ' LIMIT 1';
        $db_result = self::driver()->query($query);
        if (!$db_result->num_rows) {
            return null;
        }

        $model = new static();
        $model->load($db_result->fetch_assoc());
        $model->afterFind();

        return $model;
    }

    public static function findAllByAndCondition()
    {
        $args = func_get_args();
        foreach ($args as $i => $arg) {
            $where[] = '`' . $arg[0] . '`' . $arg[2] . '\'' . $arg[1] . '\'';
        }
        $sWhere = implode(' AND ', $where);

        $query = 'SELECT * FROM ' . static::tableName() . ' WHERE ' . $sWhere . ' ORDER BY ' . static::$defaultSort;
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

    public static function findAll()
    {
        $query = 'SELECT * FROM ' . static::tableName() . ' ORDER BY ' . static::$defaultSort;
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

    public function delete()
    {
        $query = 'DELETE FROM ' . static::tableName() . ' WHERE `id`=' . $this->id;
        return self::driver()->query($query);
    }

    public function insert()
    {
        $keys = $this->keys();
        $values = $this->values();
        foreach ($keys as $i => $key) {
            $sKeys[] = '`' . $key . '`';
        }
        foreach ($values as $i => $value) {
            $sValues[] = '\'' . $value . '\'';
        }
        $sKeys = implode(',', $sKeys);
        $sValues = implode(',', $sValues);

        $query = 'INSERT INTO `' . static::tableName() . '` (' . $sKeys . ') VALUES (' . $sValues . ')';

        $db_result = self::driver()->query($query);
        if (!$db_result) {
            $this->addError('dberror', self::driver()->connection()->error);
        }

        return self::driver()->connection()->insert_id;
    }

    public function update()
    {
        $keys = $this->keys();
        $values = $this->values();
        $set = '';
        foreach ($keys as $i => $key) {
            $set[] = '`' . $key . '`' . '=' . '\'' . $values[$i] . '\'';
        }
        $set = implode(',', $set);

        $query = 'UPDATE `' . static::tableName() . '` SET ' . $set . ' WHERE `id` = ' . $this->id;
        $db_result = self::driver()->query($query);
        if (!$db_result) {
            $this->addError('dberror', self::driver()->connection()->error);
        }

        return (self::driver()->connection()->affected_rows > 0);
    }

    public static function insertAll(array $input)
    {
        $keys = $input[0]->keys();
        $sKeys = [];
        $aValues = [];
        foreach ($keys as $i => $key) {
            $sKeys[] = '`' . $key . '`';
        }
        $sKeys = implode(',', $sKeys);
        foreach ($input as $model) {
            $values = $model->values();
            $tmpValues = [];
            foreach ($values as $i => $value) {
                $tmpValues[] = '\'' . $value . '\'';
            }
            $aValues[] = '('.implode(',', $tmpValues).')';
        }
        $sValues = implode(',', $aValues);

        $query = 'INSERT INTO `' . static::tableName() . '` (' . $sKeys . ') VALUES ' . $sValues;
        return self::driver()->query($query);
    }

    public static function driver()
    {
        return Mysqli::instance();
    }


}