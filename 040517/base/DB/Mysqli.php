<?php


namespace V_Corp\base\DB;


class Mysqli implements IDriver
{

    private static $_instance = null;
    private $_db_host = 'localhost';
    private $_db_user = 'corpcenter';
    private $_user_pswd = '12345678';
    private $_db_name = 'corpcenter';
    private $_connect = null;

    protected $_table = null;
    protected $_select = [];
    protected $_where = [];
    protected $_order = '';
    protected $_limit = 0;

    private function __construct()
    {
        $this->_connect = new \mysqli($this->_db_host, $this->_db_user, $this->_user_pswd, $this->_db_name);
        if (mysqli_connect_errno()) {
            throw new \mysqli_sql_exception(mysqli_connect_error());
        }
    }

    private function __clone()
    {
    }

    public function __destruct()
    {
        //self::close();
    }

    public static function instance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public static function connection()
    {
        if (!self::$_instance) {
            self::instance();
        }
        return self::$_instance->_connect;
    }

    public static function close()
    {
        if (null !== self::$_instance) {
            self::$_instance->_connect->close();
            self::$_instance = null;
        }
    }

    public static function query($query)
    {
        $db_result = self::$_instance->_connect->query($query);
        if (self::$_instance->_connect->errno) {
            throw new \mysqli_sql_exception(self::$_instance->_connect->error);
        }
        return $db_result;
    }

    public function create(array $input)
    {

    }

    public function setTable($table_name)
    {
        $this->_table = $table_name;
    }

    protected function check_columns(array $input)
    {
        return array_values(array_intersect(array_keys($this->_table->fields()), $input));
    }

    protected function pre_select($input)
    {
        return $input;
    }

    protected function pre_where($input)
    {
        return $input;
    }

    protected function pre_order($input)
    {
        return $input;
    }

    protected function pre_limit($input)
    {
        return $input;
    }

    public function read(Table $model, array $input = [])
    {
        $this->_table = $model;
        $this->_select = array_key_exists('select', $input) ? $this->pre_select($input['select']) : '*';
        $this->_where = array_key_exists('where', $input) ? $this->pre_where($input['where']) : '1';
        $this->_order = array_key_exists('order', $input) ? $this->pre_order($input['order']) : '';
        $this->_limit = array_key_exists('limit', $input) ? $this->pre_limit($input['limit']) : '';

        $query =
            'SELECT ' . $this->_select
            . ' FROM ' . $this->_table->tableName()
            . ' WHERE ' . $this->_where
            . ' ' . $this->_order
            . ' ' . $this->_limit;


        $result = self::query($query);
        $db_result = [];
        if ($result) {
            while ($row = $result->fetch_object()) {
                $db_result[] = $row;
            }
        }

        return $db_result;
    }

    public function update(Table $model, array $input, $data)
    {
        $this->_where = array_key_exists('where', $input) ? $this->pre_where($input['where']) : '1';
        $db_update = [];
        foreach ($data as $key => $value) {
            $db_update[] = '`'.$key.'`'.'='.'\''.$value.'\'';
        }
        $db_str_update = implode(',', $db_update);
        $query = 'UPDATE '.$model->tableName().' SET '.$db_str_update.' WHERE '.$this->_where;

        return self::query($query);
    }

    public function delete(Table $model, array $input)
    {
        $this->_table = $model;
        $this->_where = array_key_exists('where', $input) ? $this->pre_where($input['where']) : '1';

        $query =
            'DELETE FROM ' . $this->_table->tableName()
            . ' WHERE ' . $this->_where;

        return self::query($query);
    }


}