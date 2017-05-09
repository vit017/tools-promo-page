<? use V_Corp\base\Filer; ?>
<? if ($this->data->header): ?>
    <div class="promo__header">
        <?= $this->data->header; ?>
    </div>
<? endif; ?>

<? foreach ((array)$this->data->products as $key => $product): ?>
    <div class="product">
        <div class="product__title">
            <?= $product->name; ?>
        </div>
        <div class="product__photo">
            <img src="<?= Filer::getPreview($product->photo, 350, 150); ?>" alt="<?= $product->name; ?>">
        </div>
        <div class="product__articul">
            <?= $product->articul; ?>
        </div>
        <div class="product__price">
            <?= $product->price; ?>&nbsp;<?= $product->currency; ?>
        </div>
    </div>
<? endforeach; ?>

<? if ($this->data->footer): ?>
    <div class="promo__footer">
        <?= $this->data->footer; ?>
    </div>
<? endif; ?>