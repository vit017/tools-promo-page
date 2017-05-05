<?php
use V_Corp\base\Html;
?>
<?
$model = $this->data;
$errors = $model->getErrors() ?>
<? if (count($errors)): ?>
    <? foreach ($errors as $error): ?>
        <p class="form-error"><?= $error?></p>
    <? endforeach; ?>
<? endif; ?>
<form action="" method="post" enctype="multipart/form-data">
    <? $types = $model->types() ?>
    <? $attributes = $model->attributes() ?>
    <? $errors = $model->getErrors() ?>
    <? foreach ($attributes as $key => $label) {
        echo '<div class="form-group">';
        switch ($types[$key]) {
            case 'noedit':
                echo Html::noedit($label, $key, $model->$key);
                break;
            case 'raw':
                $model->$key = htmlspecialchars($model->$key);
                echo Html::raw($label, $key, $model->$key);
                break;
            case 'date':
                echo Html::date($label, $key, $model->$key);
                break;
            case 'text':
                $model->$key = htmlspecialchars($model->$key);
                echo Html::text($label, $key, $model->$key);
                break;
        }
        echo '</div>';
    }
    ?>
    <input class="btn btn-default" id="save" type="submit" value="Submit">
</form>