<?php
use V_Corp\base\Html;
use V_Corp\base\Filer;
use V_Corp\common\models\PromoModel;

?>

<form action="" method="post" enctype="multipart/form-data">
    <? $types = $this->model->types() ?>
    <? $attributes = $this->model->attributes() ?>
    <? $pages = PromoModel::findAll() ?>
    <?
    $arPages = [];
    foreach ($pages as $page) {
        $arPages[$page->id] = ['label' => $page->name, 'value' => $page->id];
    }
    ?>
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
            case 'page':
                echo Html::select($this->data->page->id, $key, $arPages);
                break;
            case 'img':
                $data = Filer::getPreview($data);
                echo Html::img($attributes[$key], $key, $data);
                break;
        }
        echo '</div>';
    }
    ?>
    <input class="btn btn-default" id="save" type="submit" value="Submit">
</form>