<?php


namespace V_Corp\base;


use V_Corp\base\db\Mysqli;
use V_Corp\base\exceptions\RouteException;

class App
{

    public $homeUrl = '/';
    public $manageUrl = '/manager/';

    private static $_title = '';
    private static $_instance = null;


    private function __construct()
    {
        session_start();
        $this->db()->open();
    }

    private function __clone()
    {
    }

    public function __destruct()
    {

    }

    public static function instance()
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

    public function request($request)
    {
        call_user_func($request['handler'], $request['params']);
    }

    public function db()
    {
        return Mysqli::instance();
    }


}