<?php


namespace V_Corp\base;

class Pagination
{

    protected $countPage;
    protected $count;
    protected $viewPath;
    protected $view;



    public function __construct($count, $countPage, $current)
    {
        $this->count = $count;
        $this->countPage = $countPage;
        $this->current = $current;
        $this->active = (+$_GET[$this->param] >= 1) ? +$_GET[$this->param] : 1;
    }

    public function show()
    {
        include_once $this->viewPath . '/' . $this->view;
    }

}