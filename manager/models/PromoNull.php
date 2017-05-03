<?php


namespace V_Corp\manager\models;


class PromoNull extends Promo {


    public function __construct()
    {

    }

    public function findAll()
    {
        return $this->find();
    }

}