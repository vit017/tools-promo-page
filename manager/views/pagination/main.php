<? $pages = ceil($this->count / $this->countPage); ?>
<? if ($pages > 1): ?>
    <nav aria-label="Page navigation" class="text-center">
        <ul class="pagination">
            <? for ($i = 1; $i <= $pages; $i++): ?>
                <? if ($this->active === $i): ?>
                    <li class="page-item active">
                        <span class="page-link"><?= $i ?></span>
                    </li>
                <? else: ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= '?' . $this->param . '=' . $i ?>"><?= $i ?></a>
                    </li>
                <? endif; ?>
            <? endfor; ?>
        </ul>
    </nav>
<? endif; ?>