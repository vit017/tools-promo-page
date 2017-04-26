<?php


class DBTable
{
    protected static $_driver = DBMysqli::class;

    protected function __construct()
    {
        $this->set_columns();
    }

    private function __clone()
    {
    }

    protected function set_columns()
    {
        $query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '{$this->_name}'";
        $db_result = self::$_driver::query($query);
        while ($row = $db_result->fetch_row()) {
            array_push($this->_columns, $row[0]);
        }
    }

    protected function check_columns(array $input)
    {
        return array_values(array_intersect($this->_columns, $input));
    }

    protected function pre_select(array $input)
    {
        $cols = $this->check_columns($input);
        $pre = [];
        foreach ($cols as $col) {
            $pre[] = '`' . $col . '`';
        }
        return count($pre) ? implode(',', $pre) : '*';
    }

    protected function pre_filter(array $input)
    {
        $cols = $this->check_columns(array_keys($input));
        $pre = [];
        foreach ($cols as $col) {
            $pre[] = '`' . $col . '`' . '=' . '\'' . $input[$col] . '\'';
        }

        return count($pre) ? implode(',', $pre) : '1';
    }

    protected function pre_order(array $input)
    {
        $cols = $this->check_columns(array_keys($input));
        $pre = [];
        foreach ($cols as $col) {
            if (in_array(strtolower($input[$col]), ['asc', 'desc'])) {
                $pre[] = '`' . $col . '`' . ' ' . $input[$col];
            }
        }

        return count($pre) ? 'ORDER BY ' . implode(',', $pre) : '';
    }

    protected function pre_limit(int $limit) {
        return ($limit <= 0) ? '' : 'LIMIT ' . $limit;
    }

    protected function pre_read(array $select, array $filter, array $order, int $limit)
    {
        $db_filter = $this->pre_filter($filter);
        $db_select = $this->pre_select($select);
        $db_order = $this->pre_order($order);
        $db_limit = $this->pre_limit($limit);

        return "SELECT {$db_select} FROM `{$this->_name}` WHERE {$db_filter} {$db_order} {$db_limit}";
    }

    protected function pre_create(array $values) {
        $db_keys = [];
        $db_values = [];
        $db_str_values = '';
        foreach ($this->_columns as $i => $col) {
            $db_keys[$i] = '`'.$col.'`';
            $db_values[$i] = array_key_exists($col, $values) ? '\''.$values[$col].'\'' : 'NULL';
        }
        $db_str_keys = implode(',',$db_keys);
        $db_str_values = implode(',',$db_values);

        return "INSERT INTO `{$this->_name}` ({$db_str_keys}) VALUES ({$db_str_values})";
    }

    public function read(array $select, array $filter, array $order, int $limit)
    {
        $db_query = $this->pre_read($select, $filter, $order, $limit);
        $db_result = [];
        $find = self::$_driver::query($db_query);
        if ($find) {
            while ($row = $find->fetch_object()) {
                $db_result[] = $row;
            }
        }

        return $db_result;
    }

    public function create(array $values) {
        $db_query = $this->pre_create($values);
        $created = self::$_driver::query($db_query);
        if ($created) {
            return self::$_driver::instance()->insert_id;
        }

        return false;
    }
}

class TB_Stock extends DBTable
{
    protected $_name = 'corp_stock';
    protected $_columns = [];

    protected static $_instance = null;

    protected function __construct()
    {
        $this->set_columns();
    }

    protected function __clone()
    {
    }

    public static function instance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }
}

class TB_Product extends DBTable
{
    protected $_prefix = 'corp_';
    protected $_name = 'product';
    protected $_columns = [];

    protected static $_instance = null;

    protected function __construct()
    {
        $this->set_columns();
    }

    protected function __clone()
    {
    }

    public static function instance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }
}