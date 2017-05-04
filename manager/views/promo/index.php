<a href="/manager/promo/add">Add Promo</a>
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
                <a href="/manager/promo/update?id=<?= $model->id ?>"><span
                        class="glyphicon glyphicon-pencil"></span></a>
                <a href="/manager/promo/delete?id=<?= $model->id ?>"><span
                        class="glyphicon glyphicon-remove"></span></a>
            </td>
        </tr>
    <? endforeach; ?>
    </tbody>
</table>
