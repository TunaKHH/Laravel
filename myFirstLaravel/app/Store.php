<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
class Store extends Model
{
    //
    static function getAllCostOfUser($id){
        $results = DB::select('select orders.name as orders_name, users.name as team_buyer, size, price_s, price_m, price_l,orders.created_at
                                    from users_orders, orders, menus, users
                                    where users_id  = ?
                                    And users.id = orders.user_id
                                    And users_orders.orders_id = orders.id
                                    And users_orders.menus_id = menus.id
                                    Order By orders.created_at DESC'
                                    , array($id));

        return $results;
    }
    static function getAllUsers(){
        $results = DB::select('select id ,name ,email ,permission from users');
        return $results;
    }

    static function getOrderLock($id){
        $results = DB::select('select lock_type from orders where id = ?', array($id));
        return $results;
    }

    static function getAllStores(){
        $results = DB::select('select * from stores');
        return $results;
    }

    static function getAllOrders(){
        $results = DB::select('select stores.id as store_id, orders.id as orderId, orders.name as orderName, users.name as userName, stores.name as storeName,stores.telphone, stores.type, lock_type, orders.updated_at from orders, stores, users where orders.store_id = stores.id and orders.user_id = users.id Order By orders.updated_at DESC');
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

    static function setEditUserPermission($id){
        $userPermission = Store::getUserPermission($id);
        $newUserPermission = $userPermission[0]->permission==0?1:0;
        return DB::table('users')
                    ->where('id' ,$id)
                    ->update(['permission' => $newUserPermission]);

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

    static function setEditStoreAndMenu($id, $ProductName, $PriceS, $PriceM, $PriceL, $storeName, $storeTel, $store_id){
        // DB::table('stores')
        //     ->where('id' ,$store_id)
        //     ->update(['permission' => $newUserPermission]);
        for($i = 0; $i < count($id); $i++){
            if(isset($ProductName[$i])){
                DB::table('menus')
                            ->where('id' , $id[$i])
                            ->update(array('name' => isset($ProductName[$i]) ? $ProductName[$i] : '0', 'price_s' => isset($PriceS[$i]) ? $PriceS[$i] : '0', 'price_M' => isset($PriceM[$i]) ? $PriceM[$i] : '0', 'price_L' => isset($PriceL[$i]) ? $PriceL[$i] : '0'));
            }
        }
    }

    static function getUserPermission($id){
        $userPermission = DB::table('users')
                            ->where('id' ,$id)
                            ->select('permission')
                            ->get();

        return $userPermission;
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

    static function getAllUsersOrderList($id){
        $results = DB::select('select stores.name as store_name, stores.telphone as store_telphone, stores.type as store_type, users_orders.id as users_orders_id, menus.name as menu_name, size, menus.price_s, menus.price_m, menus.price_l, users.name, memo
                                from users_orders, orders, menus, users, stores
                                where orders.id = ?
                                And orders_id = orders.id
                                And users_id = users.id
                                And menus_id = menus.id
                                And menus.store_id = stores.id', array($id));
        return $results;
    }

    static function getOrdersStatistics($order_id){
        $results = DB::select('select menus.name as menus_name, size, price_s, price_m, price_l, COUNT(*) as count
                                from users_orders, menus
                                where users_orders.orders_id = ?
                                And menus.id = menus_id
                                Group By menus_name , size, price_s, price_m, price_l', array($order_id));
        return $results;
    }

    static function getStoreInfoByOrderId($id){
        $results = DB::select('select stores.name as store_name, stores.telphone as store_telphone, stores.type as store_type
                                from orders, stores
                                where orders.id = ?
                                And stores.id = store_id', array($id));
        return $results;
    }

    static function setUsersOrder($orders_id, $users_id, $menus_id, $size, $memo){
        $results = DB::table('users_orders')
                                ->insert([
                                    'orders_id' => $orders_id,
                                    'users_id' => $users_id,
                                    'menus_id' => $menus_id,
                                    'size' => $size,
                                    'memo' => $memo
                                ]);
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

    static function delUsersOrdersItem($id){
        return DB::table('users_orders')->where('id', '=', $id)->delete();
    }

    static function checkStoreTel($tel){
        return DB::table('stores')->where('telphone', '=' , $tel)->get()->count();
    }

    static function checkStoreName($name){
        return DB::table('stores')->where('name', '=' , $name)->get()->count();
    }

    static function checkPrintOrderData($id){
        return DB::table('users_orders')->where('orders_id', '=', $id)->get()->count();
    }

}
