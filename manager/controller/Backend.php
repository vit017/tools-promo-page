<?php


namespace V_Corp\manager\controller;


use V_Corp\base\Controller;
use V_Corp\manager\models\Promo;



class Backend extends Controller{



    public static function index() {
        
        
        $response = Promo::findAll();


        return Render::out('index', $response);
        
    }


}


