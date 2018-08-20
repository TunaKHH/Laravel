<?php

namespace App\Http\Controllers;

use Request;
use App\Store;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stores = $this->getAllStores();
        return view('order')->with('stores',$stores);        
    }

    public function store()
    {
        $stores = $this->getAllStores();
        return view('store')->with('stores',$stores);        
    }

    static private function getAllStores(){
        $results = Store::getAllStores();

        return $results;
    }

    
    public function getTheStoreAndMenuListByTheStore(){
        $result = Store::getMenuListByTheStore($_POST['id']);

        if(!count($result)>0){
            $result = $this->getOneStore($_POST['id']);
        }       

        return $result;
    }

    public function getOneStore($id){

        return $result = Store::getOneStore($id);

        // return $result;
    }

    public function setNewStore(){
        if (Request::has('setStoreName') && Request::has('setStoreTel') && Request::input('setStoreType') != "請選擇商店類型" && Request::has('setProductName'))
        {            
            $name = Request::input('setStoreName');
            $tel = Request::input('setStoreTel');
            $type = Request::input('setStoreType');
            
            $ProductName = Request::input('setProductName');            
            $PriceS = Request::input('setPriceS');
            $PriceM = Request::input('setPriceM');
            $PriceL = Request::input('setPriceL');

            Store::setNewStore($name, $tel, $type);
            Store::setNewMenu($ProductName, $PriceS, $PriceM, $PriceL, $store_id);

            return $this->store();
        }else{
            return "新增店家失敗";
        }
        
    }

    public function setNewMenu(){
        if (Request::has('setProductName'))
        {
            $ProductName = Request::input('setProductName');            
            $PriceS = Request::input('setPriceS');
            $PriceM = Request::input('setPriceM');
            $PriceL = Request::input('setPriceL');
            $id = $_POST['id'];
            
            Store::setNewMenu($ProductName, $PriceS, $PriceM, $PriceL, $id);
            return $this->store();
        }else{
            return "新增菜單失敗";
        }
        
    }

    public function setAddMenu(){

    }

    public function setEditStore(){
        
    }
    
}
