<?php


namespace V_Corp\base\db;

class MysqliModel
{

    protected static $defaultSelect = '*';
    protected static $defaultWhere = '1';
    protected static $defaultOffset = 0;
    protected static $defaultLimit = 10;
    protected static $defaultSort = '`id` DESC';


    public static function driver()
    {
        return Mysqli::instance();
    }

    public static function findAll(array $query)
    {
        $select = array_key_exists('select', $query) ? self::prepareSelect($query['select']) : static::$defaultSelect;
        $where = array_key_exists('where', $query) ? self::prepareWhere($query['where']) : static::$defaultWhere;
        $offset = array_key_exists('offset', $query) ? (int)$query['offset'] : static::$defaultOffset;
        $limit = array_key_exists('limit', $query) ? (int)$query['limit'] : static::$defaultLimit;
        $sort = array_key_exists('sort', $query) ? self::prepareSort($query['sort']) : static::$defaultSort;

        $query = 'SELECT ' . $select . ' FROM ' . static::tableName() . ' WHERE ' . $where . ' ORDER BY ' . $sort . ' ' . ' LIMIT ' . $offset . ', ' . $limit;

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

    public static function find(array $query)
    {
        $query['offset'] = 0;
        $query['limit'] = 1;

        $models = self::findAll($query);

        return $models ? $models[0] : null;
    }

    public static function count(array $query)
    {
        $select = 'COUNT(*) as count';
        $where = array_key_exists('where', $query) ? self::prepareWhere($query['where']) : static::$defaultWhere;

        $query = 'SELECT ' . $select . ' FROM ' . static::tableName() . ' WHERE ' . $where;

        $db_result = self::driver()->query($query);
        if (!$db_result->num_rows) {
            return null;
        }

        if ($row = $db_result->fetch_assoc()) {
            return +$row['count'];
        }
    }

    public function update()
    {
        $keys = $this->keys();
        $values = $this->values();
        $set = '';
        foreach ($keys as $i => $key) {
            $set[] = '`' . $key . '`' . '=' . '?';
        }
        $set = implode(',', $set);
        $query = 'UPDATE `' . static::tableName() . '` SET ' . $set . ' WHERE `'.$this->primaryKey.'` = ' . $this->{$this->primaryKey};

        $stmt = self::driver()->connection()->prepare($query);
        array_unshift($values, str_repeat('s', count($keys)));
        call_user_func_array([$stmt, 'bind_param'], self::makeRefs($values));
        if (!$stmt->execute()) {
            $this->addError('dberror', $stmt->error);
        }

        return true;
    }

    public function delete()
    {
        $query = 'DELETE FROM ' . static::tableName() . ' WHERE `'.$this->primaryKey.'`=' . $this->{$this->primaryKey};
        return self::driver()->query($query);
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
            $aValues[] = '(' . implode(',', $tmpValues) . ')';
        }
        $sValues = implode(',', $aValues);

        $query = 'INSERT INTO `' . static::tableName() . '` (' . $sKeys . ') VALUES ' . $sValues;

        $db_result = self::driver()->query($query);

        if (!$db_result) {
            $result = ['result' => false, 'message' => self::driver()->connection()->error];
        }
        else {
            $result = ['result' => true, 'count' => self::driver()->connection()->affected_rows];
        }

        return $result;
    }

    public function insert()
    {
        $keys = $this->keys();
        $values = $this->values();
        foreach ($keys as $i => $key) {
            $sKeys[] = '`' . $key . '`';
        }
        $sKeys = implode(',', $sKeys);

        $sBinds = implode(',', array_pad([], count($keys), '?'));

        $query = 'INSERT INTO `' . static::tableName() . '` (' . $sKeys . ') VALUES (' . $sBinds . ')';
        $stmt = self::driver()->connection()->prepare($query);
        array_unshift($values, str_repeat('s', count($keys)));
        call_user_func_array([$stmt, 'bind_param'], self::makeRefs($values));
        if (!$stmt->execute()) {
            $this->addError('dberror', $stmt->error);
        }

        return $stmt->insert_id;
    }

    protected static function makeRefs(array $arr) {
        $refs = array();
        foreach($arr as $key => $value)
            $refs[$key] = &$arr[$key];

        return $refs;
    }

    protected static function prepareSelect(array $select)
    {
        $arSelect = [];
        foreach ($select as $field) {
            $arSelect[] = '`' . $field . '`';
        }

        return count($arSelect) ? implode(',', $arSelect) : static::$defaultSelect;
    }

    protected static function prepareWhere(array $where)
    {
        $logic = strtoupper($where['logic']);
        $logic = in_array($logic, ['OR', 'AND']) ? $logic : 'AND';
        $arWhere = [];

        foreach ($where['condition'] as $condition) {
            $arWhere[] = '`' . $condition[0] . '`' . $condition[2] . '\'' . $condition[1] . '\'';
        }

        return count($arWhere) ? implode(' ' . $logic . ' ', $arWhere) : static::$defaultWhere;
    }

    protected static function prepareSort(array $sort)
    {
        $field = key($sort);
        $val = strtoupper($sort[$field]);
        $val = in_array($val, ['ASC', 'DESC']) ? $val : 'DESC';
        $field = '`' . $field . '`';

        return $field . ' ' . $val;
    }


}