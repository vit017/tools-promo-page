<?php


namespace V_Corp\manager\controllers;


class Render
{

    public $model = null;
    public $data = null;
    public $view = '';
    public $title = '';

    protected $_layout = 'promo';
    protected $_views_path = __DIR__ . '/../views';
    protected $_layouts_path = __DIR__ . '/../views/layouts';

    public function out()
    {
        include_once $this->layout() . '/_header.php';
        include_once $this->_views_path . '/' . $this->view . '.php';
        include_once $this->layout() . '/_footer.php';
        return true;
    }

    public function layout()
    {
        return $this->_layouts_path . '/' . $this->_layout;
    }

}