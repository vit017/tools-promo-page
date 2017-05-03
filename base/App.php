<?php



namespace V_Corp\base;

use V_Corp\base\Exception\NotFoundHttpException;
use V_Corp\base\Render;

class App {


    private function __construct() {

    }
    private function __clone() {

    }




    public static function get($url, $fn) {
        try {
            if (method_exists($fn[0], $fn[1])) {
                return call_user_func($fn, $url);
            }

            throw new NotFoundHttpException('Bad request', 400);
        }
        catch (NotFoundHttpException $e) {
            //Render::out(404);
        }
    }



}