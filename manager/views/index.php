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
        <table class="table table-bordered table-responsive">
            <thead>
            <? foreach ($this->model->fields() as $key => $field): ?>
                <th><?= $field ?></th>
            <? endforeach; ?>
            <th class="table__edit"></th>
            </thead>
            <tbody>
            <? foreach ($this->data as $item): ?>
                <tr>
                    <? foreach ($this->model->fields() as $key => $field): ?>
                        <td><?= $item->$key ?></td>
                    <? endforeach; ?>
                    <td class="table__edit">
                        <a href="/manager/update?model=<?= get_class($this->model)?>&id=<?= $item->id?>"><span class="glyphicon glyphicon-pencil"></span></a>
                        <a href="/manager/delete?model=<?= get_class($this->model)?>&id=<?= $item->id?>"><span class="glyphicon glyphicon-remove"></span></a>
                    </td>
                </tr>
            <? endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
