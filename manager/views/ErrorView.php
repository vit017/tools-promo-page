<?php


namespace V_Corp\manager\views;

use V_Corp\base\App;

class ErrorView
{

    public $code;
    public $message;

    protected $view_path = __DIR__ . '/error';
    protected $layout_path = __DIR__ . '/layouts';
    public $layout = 'promo';
    public $data = null;
    public $view = '';

    public function __construct($view, $code, $message)
    {
        $this->view = $view;
        $this->code = $code;
        $this->message = $message;
    }

    public function render()
    {
        App::instance()->title($this->code.' - '.$this->message);
        include_once $this->layout_path . '/' . $this->layout . '/_header.php';
        include_once $this->view_path . '/' . $this->view . '.php';
        include_once $this->layout_path . '/' . $this->layout . '/_footer.php';
    }


}