<a href="/manager/promo/add">Add Promo</a>
<?
if (!$this->data) return;

$attrs = $this->data[0]->attributes();
unset($attrs['header']);
unset($attrs['footer']);
?>
<table class="table table-bordered table-responsive">
    <thead>
    <? foreach ($attrs as $key => $attr): ?>
        <th><?= $attr ?></th>
    <? endforeach; ?>
    <th class="table__edit"></th>
    </thead>
    <tbody>
    <? foreach ($this->data as $model): ?>
        <tr>
            <? foreach ($attrs as $key => $attr): ?>
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

<?$this->pagination->show()?>
