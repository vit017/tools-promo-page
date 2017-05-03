<?php


$p = new Promo();
$p->name = 'asdasd';
$p->save();



DB::connect();


DB::table('promo')->where(['name' => 'name 1'])->get();




DB::close();




class DB {

    public static function table($name) {
        return Table::instance();
    }

}



$model = Promo::instance();
$model->load($_POST);


$p1 = Promo()->where('where')->take(2)->skip(0)->select('name', 'code');




$user = DB::table('users')->where('name', 'John')->first();
$users = DB::table('users')->select('name', 'email')->get();
$users = DB::table('users')->skip(10)->take(5)->get();
DB::table('users')->insert(
    array('email' => 'john@example.com', 'votes' => 0)
);
DB::table('users')
    ->where('id', 1)
    ->update(array('votes' => 1));
DB::table('users')->where('votes', '<', 100)->delete();
DB::table('users')->delete();

class Promo extends DB\Table {


    public function table() {
        return 'corp_product';
    }

    public function rules() {
        return [
            ['name', 'required']
        ];
    }




}
