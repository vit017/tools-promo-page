<?php


class DBMysqli
{
    private static $_instance = null;
    private $_db_host = 'localhost';
    private $_db_user = 'corpcenter';
    private $_user_pswd = '12345678';
    private $_db_name = 'corpcenter';
    private $_connect = null;

    private function __construct()
    {
        $this->_connect = @new mysqli($this->_db_host, $this->_db_user, $this->_user_pswd, $this->_db_name);
        if (mysqli_connect_errno()) {
            throw new mysqli_sql_exception(mysqli_connect_error());
        }
    }

    private function __clone()
    {
    }

    public static function connect()
    {
        if (null === self::$_instance) {
            self::$_instance = (new self())->_connect;
        }
    }

    public static function close()
    {
        if (null !== self::$_instance) {
            self::$_instance->close();
            self::$_instance = null;
        }
    }

    public static function query($query)
    {
        return self::$_instance->query($query);
    }
}