<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
class Store extends Model
{
    //
    static function getAllStores(){
        $results = DB::select('select * from stores');
        return $results;
    }

    static function getAllOrders(){
        $results = DB::select('select orders.id as orderId, orders.name as orderName, users.name as userName, stores.name as storeName,stores.telphone, stores.type, lock_type, orders.updated_at from orders, stores, users where orders.store_id = stores.id and orders.user_id = users.id Order By 1 DESC');
        return $results;
    }

    static function getMenuListByTheStore($id){
        $results = DB::select('select s.name as name, s.telphone as telphone, type, m.name as mname, m.price_s,m.price_m, m.price_l from menus as m,stores as s where m.store_id=s.id and s.id=?', array($id));

        // return json_encode($results);
        return $results;
    }

    static function setNewOrder($id, $name, $store){
        // $created_at = $updated_at = Carbon::now();
        // $date = Carbon::now();
        // print_r(Carbon::now());
        $date = json_decode(json_encode(Carbon::now()),true);
        $created_at = $date['date'];
        $updated_at = $created_at;
        // print_r(json_decode($date,true));
        return DB::insert('insert into orders (name, user_id, store_id, lock_type, created_at, updated_at) values (?, ?, ?, ?, ?, ?)', array($name, $id, $store, 0, $created_at, $updated_at));

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

    static function delOrder($id){
        return DB::table('orders')->where('id', '=', $id)->delete();
    }
}