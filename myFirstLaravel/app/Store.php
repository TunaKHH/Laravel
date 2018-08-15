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

    static function setNewStore($name, $tel, $type){
        DB::insert('insert into stores (name,telphone,type) values (?, ?, ?)', array($name, $tel, $type));
    }

    static function setNewMenu($name, $tel, $type){
        DB::insert('insert into stores (name,telphone,type) values (?, ?, ?)', array($name, $tel, $type));
    }

    static function getOneStore($id){
        $results = DB::select('select * from stores where id=?', array($id));
        $json_arr = array(
            'name' => $results[0]->name,
            'tel' => $results[0]->telphone,
        );
        return json_encode($json_arr);        
    }

    static function setEditStore($data){

    }
}