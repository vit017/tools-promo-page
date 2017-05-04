<?php
dd(__FILE__, 0);
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1><?= $this->title ?></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered table-responsive">
                <thead>
                <? foreach ($this->model->attributes() as $key => $attr): ?>
                    <th><?= $attr ?></th>
                <? endforeach; ?>
                <th class="table__edit"></th>
                </thead>
                <tbody>
                <? foreach ($this->data as $model): ?>
                    <tr>
                        <? foreach ($this->model->attributes() as $key => $attr): ?>
                            <td><?= $model->$key ?></td>
                        <? endforeach; ?>
                        <td class="table__edit">
                            <a href="/manager/promo/update?model=<?= get_class($this->model) ?>&id=<?= $model->id ?>"><span
                                    class="glyphicon glyphicon-pencil"></span></a>
                            <a href="/manager/promo/delete?model=<?= get_class($this->model) ?>&id=<?= $model->id ?>"><span
                                    class="glyphicon glyphicon-remove"></span></a>
                        </td>
                    </tr>
                <? endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
