<?php
dd(__FILE__, 0);
use V_Corp\base\Html;

?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1><?= $this->title ?></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form action="" method="post" enctype="multipart/form-data">
                <? $types = $this->model->types() ?>
                <? $attributes = $this->model->attributes() ?>
                <? foreach ($this->data as $key => $data) {
                    echo '<div class="form-group">';
                    switch ($types[$key]) {
                        case 'noedit':
                            echo Html::noedit($attributes[$key], $key, $data);
                            break;
                        case 'raw':
                            echo Html::raw($attributes[$key], $key, $data);
                            break;
                        case 'date':
                            echo Html::date($attributes[$key], $key, $data);
                            break;
                        case 'text':
                            echo Html::text($attributes[$key], $key, $data);
                            break;
                    }
                    echo '</div>';
                }
                ?>
                <input class="btn btn-default" id="save-promo" type="submit" value="Submit">
            </form>
        </div>
    </div>