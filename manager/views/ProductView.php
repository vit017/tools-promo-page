<?php


namespace V_Corp\manager\views;

use V_Corp\base\controllers\Controller;
use V_Corp\base\views\View;

class ProductView extends View
{

    protected $view_path = __DIR__ . '/product';
    protected $layout_path = __DIR__ . '/layouts';
    public $layout = 'promo';
    public $data = null;
    public $view = '';

    public function __construct($view, $data)
    {
        $this->view = $view;
        $this->data = $data;
    }

    public function render()
    {
        include_once $this->layout_path . '/' . $this->layout . '/_header.php';
        include_once $this->view_path . '/' . $this->view . '.php';
        include_once $this->layout_path . '/' . $this->layout . '/_footer.php';
    }


}