<?php


require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/DBDriver.php';
require_once __DIR__ . '/DBTable.php';







DBMysqli::connect();

$tb_stock = TB_Stock::instance();


$res = $tb_stock->read([], [], ['id' => 'desc', 'name2'=>'asc'], 1);
dd($res);



DBMysqli::close();

class Stock
{


    public function create()
    {

    }

    public function read()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }


}