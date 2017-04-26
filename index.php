<?php


require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/DBMysqli.php';
require_once __DIR__ . '/DBTable.php';







DBMysqli::connect();

$tb_stock = TB_Stock::instance();


$res = $tb_stock->read([], [], ['id' => 'desc', 'name2'=>'asc'], 0);
$res = $tb_stock->create([
    'name' => 'name 3',
    'code' => 'code3',
    'created_at' => time(),
    'updated_at' => time(),
    'date_active_start' => time(),
    'header' => 'header 3',
    'content' => 'контент 3',
    'footer' => 'футер 3'
]);


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