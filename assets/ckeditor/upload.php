<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';

//http://docs.ckeditor.com/#!/guide/dev_file_browser_api
$funcNum = $_GET['CKEditorFuncNum'];
$file_name = str2url($_FILES['upload']['name']);
$file_name_tmp = $_FILES['upload']['tmp_name'];
$file_new_name = $_SERVER['DOCUMENT_ROOT'].'/assets/img/';
$full_path = $file_new_name.$file_name;
$http_path = '/assets/img/'.$file_name;
$error = '';
if( move_uploaded_file($file_name_tmp, $full_path) ) {
} else {
    $error = 'Some error occured please try again later';
    $http_path = '';
}

echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction('$funcNum', '$http_path', '$error');</script>";