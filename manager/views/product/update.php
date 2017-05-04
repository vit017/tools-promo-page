<?php
use V_Corp\base\Html;

?>

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
    <input class="btn btn-default" id="save" type="submit" value="Submit">
</form>