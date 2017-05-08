<? use V_Corp\base\App; ?>
<style>
    .errors {
        font-size: 46px;
        text-align: center;
    }

    .error-code {

    }
</style>


<div class="errors">
    <p class="error-code"><?= $this->code ?></p>
</div>
<div class="errors">
    <p class="error-code"><?= $this->message ?></p>
</div>
<div class="text-center">
    <a href="<?= App::instance()->homeUrl ?>">Home</a>
</div>