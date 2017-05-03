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
                <? $fields = $this->model->fields() ?>
                <? foreach ($this->data[0] as $key => $data) {
                    echo '<div class="form-group">';
                    switch ($types[$key]) {
                        case 'noedit':
                            echo Html::noedit($fields[$key], $key, $data);
                            break;
                        case 'raw':
                            echo Html::raw($fields[$key], $key, $data);
                            break;
                        case 'date':
                            echo Html::date($fields[$key], $key, date('d.m.Y', $data));
                            break;
                        case 'text':
                            echo Html::text($fields[$key], $key, $data);
                            break;
                    }
                    echo '</div>';
                }
                ?>

                <!--div class="form-group">
                <label>Дата начала показа страницы</label>
                <div class='input-group date datetimepicker'>
                    <input type='text' name="date_show_start"
                           placeholder="Дата начала показа страницы"
                           class="form-control require"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>

            <div class="form-group">
                <label>Дата окончания показа страницы</label>
                <div class='input-group date datetimepicker'>
                    <input type='text' name="date_show_end" placeholder="Дата окончания показа страницы"
                           class="form-control require"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>

            <div class="form-group">
                <label>URL страницы</label>
                <div class='input-group'>
                        <span class="input-group-addon">
                            <span><?= $_SERVER["REQUEST_SCHEME"] . '://' . $_SERVER["HTTP_HOST"] . '/' ?></span>
</span>
                    <input type='text' name="url" placeholder="URL страницы"
                           class="form-control require"/>
                </div>
            </div>

            <div class="form-group">
                <label>Название акции</label>
                <input type='text' name="name" placeholder="Название акции" class="form-control require"/>
            </div>

            <div class="form-group">
                <label>Шапка</label>
                <textarea name="header" class="form-control editor" id="" cols="30" rows="10"></textarea>
            </div>

            <div class="form-group">
                <label>Подвал</label>
                <textarea name="footer" class="form-control editor" id="" cols="30" rows="10"></textarea>
            </div-->

                <input class="btn btn-default" id="save-promo" type="submit" value="Submit">
            </form>
        </div>
    </div>