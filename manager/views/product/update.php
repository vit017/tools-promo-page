<?php
use V_Corp\base\Html;
use V_Corp\base\Filer;
use V_Corp\common\models\PromoModel;

?>
<?
$model = $this->data;
$types = $model->types();
$attributes = $model->attributes();
$errors = $model->getErrors();
?>
<? if (count($errors)): ?>
    <?// only db errors?>
    <? foreach ($errors as $key => $error): ?>
        <? if (array_key_exists($key, $attributes)) continue; ?>
        <p class="form-error"><?= $error ?></p>
    <? endforeach; ?>
<? endif; ?>
<form action="" method="post" enctype="multipart/form-data">
    <?
    $pages = PromoModel::findAll([]);
    $arPages = [];
    foreach ($pages as $page) {
        $arPages[$page->id] = ['label' => $page->name, 'value' => $page->id];
    }
    ?>
    <? foreach ($attributes as $key => $label) {
        $class = array_key_exists($key, $errors) ? 'has-error' : '';
        echo '<div class="form-group ' . $class . '">';
        switch ($types[$key]) {
            case 'noedit':
                echo Html::noedit($label, $model->$key);
                break;
            case 'raw':
                echo Html::raw($label, $key, $model->$key);
                echo array_key_exists($key, $errors)
                    ?
                    '<span class="help-block">' . $errors[$key] . '</span>'
                    : '';
                break;
            case 'date':
                echo Html::date($label, $key, $model->$key);
                echo array_key_exists($key, $errors)
                    ?
                    '<span class="help-block">' . $errors[$key] . '</span>'
                    : '';
                break;
            case 'text':
                echo Html::text($label, $key, $model->$key);
                echo array_key_exists($key, $errors)
                    ?
                    '<span class="help-block">' . $errors[$key] . '</span>'
                    : '';
                break;
            case 'page':
                echo Html::select($label, $key, $arPages, $model->page->id);
                break;
            case 'img':
                if ($model->$key) {
                    $model->$key = Filer::getPreview($model->$key);
                }
                echo Html::img($label, $key, $model->$key);
                echo array_key_exists($key, $errors)
                    ?
                    '<span class="help-block">' . $errors[$key] . '</span>'
                    : '';
                break;
        }
        echo '</div>';
    }
    ?>
    <input class="btn btn-default" id="save" type="submit" value="Submit">
</form>