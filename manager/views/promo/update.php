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
                $data = htmlspecialchars($data);
                echo Html::raw($attributes[$key], $key, $data);
                break;
            case 'date':
                echo Html::date($attributes[$key], $key, $data);
                break;
            case 'text':
                $data = htmlspecialchars($data);
                echo Html::text($attributes[$key], $key, $data);
                break;
        }
        echo '</div>';
    }
    ?>
    <input class="btn btn-default" id="save-promo" type="submit" value="Submit">
</form>