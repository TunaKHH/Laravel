<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Store extends Model
{
    //
    static function getAllStores(){
        $results = DB::select('select * from stores');
        return $results;
    }

    static function getMenuListByTheStore($id){
        $results = DB::select('select * from menus,stores where menus.store_tel=stores.telphone and', array($id));
        return $results;
    }

    static function setNewStore($name, $tel, $type){
        DB::insert('insert into stores (name,telphone,type) values (?, ?, ?)', array($name, $tel, $type));
    }

    static function setNewMenu($ProductName, $PriceS, $PriceM, $PriceL, $tel){
        for($i = 0; $i<count($ProductName); $i++){
            DB::insert('insert into menus (name,price_s,price_m,price_l,store_tel) values (?, ?, ?, ?, ?)', array($ProductName[$i], $PriceS[$i], $PriceM[$i], $PriceL[$i], $tel));
        }
        
    }

    static function getOneStore($id){
        $results = DB::select('select * from stores where id=?', array($id));
        $json_arr = array(
            'name' => $results[0]->name,
            'tel' => $results[0]->telphone,
            'type' => $results[0]->type,
        );
        return json_encode($json_arr);        
    }

    static function setEditStore($data){

    }
}