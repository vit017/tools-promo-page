<?php
use V_Corp\base\Html;
use V_Corp\base\Filer;
use V_Corp\common\models\PromoModel;

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
    <? $pages = PromoModel::findAll() ?>
    <?
    $arPages = [];
    foreach ($pages as $page) {
        $arPages[$page->id] = ['label' => $page->name, 'value' => $page->id];
    }
    ?>
    <? foreach ($attributes as $key => $label) {
        echo '<div class="form-group">';
        switch ($types[$key]) {
            case 'noedit':
                echo Html::noedit($label, $key, $model->$key);
                break;
            case 'raw':
                echo Html::raw($label, $key, $model->$key);
                break;
            case 'date':
                echo Html::date($label, $key, $model->$key);
                break;
            case 'text':
                echo Html::text($label, $key, $model->$key);
                break;
            case 'page':
                echo Html::select($label, $key, $arPages, $model->page->id);
                break;
            case 'img':
                if ($model->$key) {
                    $model->$key = Filer::getPreview($model->$key);
                }
                echo Html::img($label, $key, $model->$key);
                break;
        }
        echo '</div>';
    }
    ?>
    <input class="btn btn-default" id="save" type="submit" value="Submit">
</form>