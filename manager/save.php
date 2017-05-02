<?
require_once __DIR__ . '/../functions.php';
require_once __DIR__ . '/../DB/DBMysqli.php';
require_once __DIR__ . '/../DB/Table.php';




DBMysqli::connect();

$Stock = Stock::instance();
$_POST['date_show_start'] = strtotime($_POST['date_show_start']);
$_POST['date_show_end'] = strtotime($_POST['date_show_end']);
$created = $Stock->create($_POST);

DBMysqli::close();

echo json_encode(['result' => $created]);
