<?
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/DB/DBMysqli.php';
require_once __DIR__ . '/DB/Table.php';

DBMysqli::connect();











$Stock = Stock::instance();
$Stock->read([], ['date_show_start']);





























DBMysqli::close();