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
        $results = DB::select('select s.name as name, s.telphone as telphone, type, m.name as mname, m.price_s,m.price_m, m.price_l from menus as m,stores as s where m.store_id=s.id and s.id=?', array($id));

        // return json_encode($results);
        return $results;
    }

    static function setNewStore($name, $tel, $type){
        // DB::insert('insert into stores (name,telphone,type) values (?, ?, ?)', array($name, $tel, $type));
        return DB::table('stores')->insertGetId(['name' => $name, 'telphone' => $tel, 'type' => $type]);
    }

    static function setNewMenu($ProductName, $PriceS, $PriceM, $PriceL, $id){
        for($i = count($ProductName)-1; $i>=0; $i--){
            DB::insert('insert into menus (name,price_s,price_m,price_l,store_id) values (?, ?, ?, ?, ?)', array($ProductName[$i], $PriceS[$i], $PriceM[$i], $PriceL[$i], $id));
        }
        
    }

    static function getOneStore($id){
        $results = DB::select('select * from stores where id=?', array($id));
        
        return $results;        
    }

    static function setEditStore($data){

    }

    static function delStoreAndTheMenu($id){
        DB::table('stores')->where('id', '=', $id)->delete();
        return DB::table('menus')->where('store_id', '=', $id)->delete();
    }
}