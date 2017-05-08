<?php



namespace V_Corp\manager\views;

use V_Corp\base\views\View;

class ManageView extends View {

    protected $layoutPath = __DIR__ . '/layouts';

    public function __construct($view, $data)
    {
        $this->view = $view;
        $this->data = $data;
    }

    public function render()
    {
        include_once $this->layoutPath . '/' . $this->layout . '/_header.php';
        include_once $this->viewPath . '/' . $this->view . '.php';
        include_once $this->layoutPath . '/' . $this->layout . '/_footer.php';
    }

}