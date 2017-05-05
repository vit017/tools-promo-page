<?= $this->data->header; ?>

<? foreach ((array)$this->data->products as $key => $product): ?>
    <div class="product">
        <div class="product__title">
            <?= $product->name; ?>
        </div>
        <div class="product__photo">
            <img src="<?= $product->photo; ?>" alt="<?= $product->name; ?>">
        </div>
        <div class="product__articul">
            <?= $product->articul; ?>
        </div>
        <div class="product__price">
            <?= $product->price; ?>&nbsp;<?= $product->currency; ?>
        </div>
    </div>
<? endforeach; ?>

<?= $this->data->footer; ?>