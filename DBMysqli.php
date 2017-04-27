<?php

//DBMysqli::connect();
//DBMysqli::close();


interface DBDriver {


    /**
     * @return {Driver instance}
     */
    public static function instance();


    /**
     * Send query to db
     * @return {Driver db result}
     */
    public static function query($query);
}

class DBMysqli implements DBDriver
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

    public static function instance() {
        return self::$_instance;
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
        $db_result = self::$_instance->query($query);
        if (self::$_instance->errno) {
            throw new mysqli_sql_exception(self::$_instance->error);
        }
        return $db_result;
    }
}