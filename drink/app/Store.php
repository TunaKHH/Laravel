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
        $results = DB::select('select stores.id as store_id, orders.id as orderId, orders.name as orderName, users.name as userName, stores.name as storeName,stores.telphone, stores.type, lock_type, orders.updated_at from orders, stores, users where orders.store_id = stores.id and orders.user_id = users.id Order By 1 DESC');
        return $results;
    }

    static function getMenuListByTheStore($id){
        $results = DB::select('select m.id as mid,s.name as name, s.telphone as telphone, type, m.name as mname, m.price_s,m.price_m, m.price_l from menus as m,stores as s where m.store_id=s.id and s.id=?', array($id));

        return $results;
    }

    static function setNewOrder($id, $name, $store){
        $date = json_decode(json_encode(Carbon::now()),true);
        $created_at = $date['date'];
        $updated_at = $created_at;
        return DB::insert('insert into orders (name, user_id, store_id, lock_type, created_at, updated_at) values (?, ?, ?, ?, ?, ?)', array($name, $id, $store, 0, $created_at, $updated_at));

    }

    static function setNewStore($name, $tel, $type){
        return DB::table('stores')->insertGetId(['name' => $name, 'telphone' => $tel, 'type' => $type]);
    }

    static function setNewMenu($ProductName, $PriceS, $PriceM, $PriceL, $id){
        for($i = count($ProductName)-1; $i>=0; $i--){
            if(isset($ProductName[$i])){
                DB::insert('insert into menus (name,price_s,price_m,price_l,store_id) values (?, ?, ?, ?, ?)', array(isset($ProductName[$i]) ? $ProductName[$i] : '0', isset($PriceS[$i]) ? $PriceS[$i] : '0', isset($PriceM[$i]) ? $PriceM[$i] : '0', isset($PriceL[$i]) ? $PriceL[$i] : '0', $id));    
            }
        }
    }

    static function setEditStoreAndMenu($id, $ProductName, $PriceS, $PriceM, $PriceL){
        for($i = 0; $i < count($id); $i++){
            if(isset($ProductName[$i])){
                DB::table('menus')
                            ->where('id' , $id[$i])
                            ->update(array('name' => isset($ProductName[$i]) ? $ProductName[$i] : '0', 'price_s' => isset($PriceS[$i]) ? $PriceS[$i] : '0', 'price_M' => isset($PriceM[$i]) ? $PriceM[$i] : '0', 'price_L' => isset($PriceL[$i]) ? $PriceL[$i] : '0'));
            }
        }
    }

    static function setOrderLock($id, $type){
        return DB::table('orders')
                            ->where('id',$id)
                            ->update(['lock_type' => $type ]);
        
    }

    static function getOneStore($id){
        $results = DB::select('select * from stores where id=?', array($id));
        
        return $results;        
    }
    
    // static function getOneStoreMenuList($id){
    //     return DB::table('orders')->where('store_id', '=', $id)->get();
    // }

    static function setEditStore($data){

    }

    static function delStoreAndTheMenu($id){
        DB::table('stores')->where('id', '=', $id)->delete();
        return DB::table('menus')->where('store_id', '=', $id)->delete();
    }

    static function delOrder($id){
        return DB::table('orders')->where('id', '=', $id)->delete();
    }

    static function delOneMenu($id){
        return DB::table('menus')->where('id', '=', $id)->delete();
    }

    static function checkStoreTel($tel){
        return DB::table('stores')->where('telphone', '=' , $tel)->get()->count();
    }

    static function checkStoreName($name){
        return DB::table('stores')->where('name', '=' , $name)->get()->count();
    }
}
