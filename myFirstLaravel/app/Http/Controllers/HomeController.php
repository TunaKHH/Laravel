<?php

namespace App\Http\Controllers;

use Request;
use Redirect;
use Socialize;
use Auth;
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
        return view('store')->with('stores',$stores);        
    }

    public function store()
    {
        $stores = $this->getAllStores();

        return view('store')->with('stores',$stores);
    }

    public function order()
    {
        $stores = $this->getAllStores();
        $orders = $this->getAllOrders();
        if(Auth::check()){
            $id = Auth::user()->id;
        }else{
            Redirect::route('home');
        }
        
        return view('order')->with('orders',$orders)->with('stores',$stores)->with('userId',$id);        
    }

    static private function getAllStores(){
        $results = Store::getAllStores();

        return $results;
    }

    static private function getAllOrders(){
        $results = Store::getAllOrders();

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
        if (Request::has('setStoreName') && Request::has('setStoreTel'))
        {            
            $name = Request::input('setStoreName');
            $tel = Request::input('setStoreTel');
            $type = Request::input('setStoreType');
            $store_id = Store::setNewStore($name, $tel, $type);
            
            if(Request::has('setProductName')){
                $ProductName = Request::input('setProductName');  
                $PriceS = Request::input('setPriceS');
                $PriceM = Request::input('setPriceM');
                $PriceL = Request::input('setPriceL');
                // if(Request::has('setPriceS') && Request::has('setPriceM') && Request::has('setPriceL')){
                    
                //     Store::setNewMenu($ProductName, $PriceS, $PriceM, $PriceL, $store_id);
                // }else if(Request::has('setPriceS') && Request::has('setPriceM')){
                //     Store::setNewMenu($ProductName, $PriceS, $PriceM, $store_id);

                // }else if(Request::has('setPriceM') && Request::has('setPriceL')){
                //     Store::setNewMenu($ProductName, $PriceM, $PriceL, $store_id);

                // }else if(Request::has('setPriceS') && Request::has('setPriceL')){
                //     Store::setNewMenu($ProductName, $PriceS, $PriceL, $store_id);

                // }else if(Request::has('setPriceS') || Request::has('setPriceM') || Request::has('setPriceL')){
                //     if(!Store::setNewMenu($ProductName, $PriceS, $store_id)){
                //         if(!Store::setNewMenu($ProductName, $PriceM, $store_id)){
                //             if(!Store::setNewMenu($ProductName, $PriceL, $store_id)){return "新增菜單失敗";}
                //         }
                //     }
                // }else{
                //     return "新增菜單失敗";
                // }
                Store::setNewMenu($ProductName, $PriceS, $PriceM, $PriceL, $store_id);
            }
            
            return Redirect::route('store');
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
            return Redirect::route('store');
        }else{
            return "新增菜單失敗";
        }
        
    }

    public function setNewOrder(){
        $id = $_POST['userId'];
        $name = $_POST['name'];
        $store = $_POST['store'];
        
        if(Store::setNewOrder($id,$name,$store)){
            return 1;
        }else
        {
            return 0;
        }
        
    }

    public function setOrderLock(){
        $id = $_POST['id'];
        $lock_type = $_POST['lock_type'];

        if($lock_type){
            $lock_type = 0;
        }else{
            $lock_type = 1;
        }
            

        return Store::setOrderLock($id, $lock_type);
    }

    public function delStoreAndTheMenu(){
        $id = $_POST['id'];
        // Store::delStoreAndTheMenu($id);
        // return Redirect::route('store');
        return Store::delStoreAndTheMenu($id);
    }
    
    public function delMenu(){
        $id = $_POST['id'];
        Store::delMenu($id);
    }

    public function delOrder(){
        $id = $_POST['id'];
        return Store::delOrder($id);
    }

}
