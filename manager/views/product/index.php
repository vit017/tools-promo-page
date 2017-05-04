<?
$attrs = $this->model->attributes();
?>
<a href="/manager/product/add">Add Product</a>
<table class="table table-bordered table-responsive">
    <thead>
    <? foreach ($attrs as $key => $attr): ?>
        <th><?= $attr ?></th>
    <? endforeach; ?>
    <th class="table__edit"></th>
    </thead>
    <tbody>
    <?if (!$this->data) $this->data = []?>
    <? foreach ($this->data as $model): ?>
        <tr>
            <? foreach ($attrs as $key => $attr): ?>
                <td><?= $model->$key ?></td>
            <? endforeach; ?>
            <td class="table__edit">
                <a href="/manager/product/update?id=<?= $model->id ?>"><span
                        class="glyphicon glyphicon-pencil"></span></a>
                <a href="/manager/product/delete?id=<?= $model->id ?>"><span
                        class="glyphicon glyphicon-remove"></span></a>
            </td>
        </tr>
    <? endforeach; ?>
    </tbody>
</table>
