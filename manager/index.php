<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';


use V_Corp\base\App;
use V_Corp\manager\controller\Backend;



App::get('/', [Backend::class, 'index']);