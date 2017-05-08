<? if ($this->data): ?>
    <? $attrs = $this->data[0]->attributes(); ?>
    <a href="/manager/product/add">Add Product</a>
    <table class="table table-bordered table-responsive">
        <thead>
        <? foreach ($attrs as $key => $attr): ?>
            <th><?= $attr ?></th>
        <? endforeach; ?>
        <th class="table__edit"></th>
        </thead>
        <tbody>
        <? foreach ((array)$this->data as $model): ?>
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
<? endif; ?>
    <div class="import">
        <form action="/manager/product/import" method="post" enctype="multipart/form-data">
            <input type="file" name="import">
            <input type="submit" value="Import products">
        </form>
    </div>

    <div class="import-result">
        <? $import = call_user_func([$this->controller, 'flash'], 'import') ?>
        <?= $import ?>
    </div>

<? $this->pagination->show() ?>