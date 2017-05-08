<? if (!$this->data) return; ?>

<? foreach ($this->data as $i => $model): ?>
    <a href="<?= '/promo/' . $model->url ?>"><?= $model->name; ?></a>
    <p><?= $model->date_show_start ?> - <?= $model->date_show_end ?></p>
<? endforeach; ?>

<?$this->pagination->show()?>
