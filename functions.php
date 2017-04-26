<?php


function dd($d, $die = true) {
    echo '<pre>';
    var_dump($d);
    echo '</pre>';

    if ($die) die();
}