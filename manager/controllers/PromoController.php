<?php


namespace V_Corp\manager\controllers;

use V_Corp\base\App;
use V_Corp\common\models\PromoModel;
use V_Corp\manager\views\PromoView;

class PromoController extends ManageController
{

    protected static $model = PromoModel::class;
    protected static $view = PromoView::class;


    public static function index()
    {
        App::instance()->title('Promo pages');
        parent::index();
    }

    public static function add()
    {
        App::instance()->title('Add Promo');
        parent::save();
    }

    public static function update()
    {
        App::instance()->title('Update Promo #' . (int)$_GET['id']);
        parent::save((int)$_GET['id']);
    }

}