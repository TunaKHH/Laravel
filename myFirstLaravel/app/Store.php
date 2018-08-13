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
}