<?php
use V_Corp\base\Html;
?>
<?
$model = $this->data;
$types = $model->types();
$attributes = $model->attributes();
$errors = $model->getErrors();
?>
<? if (count($errors)): ?>
    <?// only db errors?>
    <div class="has-error">
        <? foreach ($errors as $key => $error): ?>
            <? if (array_key_exists($key, $attributes)) continue; ?>
            <span class="help-block"><?= $error ?></span>
        <? endforeach; ?>
    </div>
<? endif; ?>
<form action="" method="post" enctype="multipart/form-data">
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
                break;
            case 'date':
                echo Html::date($label, $key, $model->$key);
                echo array_key_exists($key, $errors)
                    ?
                    '<span class="help-block">' . $errors[$key] . '</span>'
                    : '';
                break;
                break;
            case 'text':
                echo Html::text($label, $key, $model->$key);
                echo array_key_exists($key, $errors)
                    ?
                    '<span class="help-block">' . $errors[$key] . '</span>'
                    : '';
                break;
                break;
        }
        echo '</div>';
    }
    ?>
    <input class="btn btn-default" id="save" type="submit" value="Submit">
</form>