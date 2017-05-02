<?php


class Stock extends Table
{
    protected $_name = 'corp_stock';
    protected $_columns = [];

    protected static $_instance = null;

    protected function __construct()
    {
        $this->set_columns();
    }

    protected function __clone()
    {
    }

    public static function instance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }
}