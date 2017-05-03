<?php


namespace V_Corp\manager\controller;


class Render
{


    public static function out($view, $response)
    {


        include_once __DIR__ . '/../view/' . $view . '.php';
        return true;


    }


}