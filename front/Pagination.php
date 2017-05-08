<?php


namespace V_Corp\front;

class Pagination
{

    protected $viewPath = __DIR__ . '/views/pagination';
    protected $view = 'main.php';

    public $param = 'page';

    public function __construct($count, $countPage, $current)
    {
        $this->count = $count;
        $this->countPage = $countPage;
        $this->current = $current;
        $this->active = (+$_GET[$this->param] >= 1) ? +$_GET[$this->param] : 1;
    }


    public function show()
    {
        if ($this->countPage < $this->count) {
            include_once $this->viewPath.'/'.$this->view;
        }
    }


}