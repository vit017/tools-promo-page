<?php


namespace V_Corp\base;


use V_Corp\base\db\Mysqli;
use V_Corp\base\exceptions\RouteException;

class App
{

    private static $_title = '';
    private static $_instance = null;


    private function __construct()
    {
        $this->db()->open();
    }

    private function __clone()
    {
    }

    public function __destruct()
    {

    }

    public static function init()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function terminate()
    {
        if (null !== self::$_instance) {
            $this->db()->close();
        }
    }


    public function title($title = '')
    {
        if (!func_num_args()) {
            return self::$_title;
        }

        self::$_title = (string)$title;
    }

    public function request($handler)
    {
        try {
            call_user_func($handler, []);
        }
        catch (RouteException $e) {
            dd($e);
        }
    }

    public function db()
    {
        return Mysqli::instance();
    }


}