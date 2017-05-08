<?php


namespace V_Corp\base\controllers;


class Controller {

    public static function flash($key, $value = null)
    {
        if (1 === func_num_args()) {
            $result = $_SESSION[$key];
            unset($_SESSION[$key]);
            return $result;
        }
        else {
            $_SESSION[$key] = $value;
        }
    }

}