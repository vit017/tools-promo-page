<?php


namespace V_Corp\base\db;

use V_Corp\base\App;

class Mysqli
{
    private $_db_host = 'localhost';
    private $_db_user = 'corpcenter';
    private $_user_pswd = '12345678';
    private $_db_name = 'corpcenter';

    private $_connect = null;
    private static $_instance = null;


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

    public function open()
    {
        self::instance();
    }

    public function close()
    {
        if (is_object($this->connection())) {
            $this->connection()->close();
        }
    }

    public function connection()
    {
        return $this->_connect;
    }

    public static function instance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function query($query)
    {
        $db_result = self::$_instance->_connect->query($query);
        if (self::$_instance->_connect->errno) {
            //throw new \mysqli_sql_exception(self::$_instance->_connect->error);
        }
        return $db_result;
    }


}