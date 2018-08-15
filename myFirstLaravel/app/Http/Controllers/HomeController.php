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

    
    public function getOneStore(){
        $result = Store::getOneStore($_POST['id']);

        return $result;
    }

    public function setNewStore(){
        if (Request::has('setStoreName') && Request::has('setStoretel') && Request::has('setStoreType'))
        {            
            $name = Request::input('setStoreName');
            $tel = Request::input('setStoretel');
            $type = Request::input('setStoreType');

            Store::setNewStore($name, $tel, $type);
            return redirect()->action('HomeController@index');
        }else{
            return "新增店家失敗";
        }
        
    }

    public function setEditStore(){
        
    }
    
}
