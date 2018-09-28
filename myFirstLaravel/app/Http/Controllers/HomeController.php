<?php
namespace App\Http\Controllers;

use Request;
use Redirect;
use Socialize;
use Auth;
use App\Store;
// use Illuminate\Http\Request;
session_start();

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
        $data = $this->getUserPermission();
        $_SESSION['userPermission'] = $data[0]->permission;
        return $this->order();
    }

    public function store()
    {
        if($_SESSION['userPermission'] == 0){
            $stores = $this->getAllStores();
            return view('store')->with('stores',$stores);
        }
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

    public function permission()
    {
        if($_SESSION['userPermission'] == 0){
            $users = $this->getAllUsers();
            if (Auth::check()) {
                $id = Auth::user()->id;
            } else {
                Redirect::route('home');
            }

            return view('permission')->with('userId', $id)->with('users', $users);
        }
    }

    public function history()
    {
        if(Auth::check()){
            $id = Auth::user()->id;
        }else{
            Redirect::route('home');
        }

        return view('history')->with('userId',$id);
    }

    public function print()
    {
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $haveData = Store::checkPrintOrderData($id);
            if($haveData != 0){
                $result = $this->getAllUsersOrderList();
                $ordersStatistics = $this->getOrdersStatistics();

            }else{
                echo "<script> alert('無訂餐資料，將導回訂餐頁面')</script>";
                return $this->order();
            }
            return view('print')->with('datas' ,$result)->with('datas2' ,$ordersStatistics);
        }else{
            return $this->order();
        }
    }

    static private function getAllStores(){
        $results = Store::getAllStores();

        return $results;
    }

    static private function getAllOrders(){
        $results = Store::getAllOrders();

        return $results;
    }

    static private function getAllUsers(){
        $results = Store::getAllUsers();

        return $results;
    }

    public function getTheStoreAndMenuListByTheStore(){

        $result = Store::getMenuListByTheStore($_POST['id']);

        if(!count($result)>0){
            $result = $this->getOneStore($_POST['id']);
        }
        return $result;
    }

    public function getUserPermission(){//取得用戶權限
        $id = Auth::user()->id;
        $result = Store::getUserPermission($id);
        return $result;
    }

    public function getOneStore($id){
        return $result = Store::getOneStore($id);
    }

    public function getAllUsersOrderList(){
        if(isset($_GET['id'])){
            $id = $_GET['id'];
        }else{
            $id = Request::input('id');
        }
        $result = Store::getAllUsersOrderList($id);

        if(!count($result) > 0){
            $result = Store::getStoreInfoByOrderId($id);
        }

        return $result;
    }

    public function getOrdersStatistics(){//取得統計資料
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $result = Store::getOrdersStatistics($id);
        }

        return $result;
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

    public function setEditUserPermission(){
        $id = Request::input('id');

        Store::setEditUserPermission($id);

        return Redirect::route('permission');
    }

    public function setEditStoreAndMenu(){
        $id = Request::input('edit_mid');
        $ProductName = Request::input('edit_mname');
        $PriceS = Request::input('edit_price_s');
        $PriceM = Request::input('edit_price_m');
        $PriceL = Request::input('edit_price_l');

        Store::setEditStoreAndMenu($id, $ProductName, $PriceS, $PriceM, $PriceL);
        return Redirect::route('store');
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

    public function setUsersOrder(){
        $order_id = Request::input('order_id');
        $user_id = Request::input('user_id');
        $menus_id = Request::input('mid');
        $quantity = Request::input('num');
        $memo = Request::input('memo');

        for($i = 0; $i < count($menus_id); $i++){
            if(isset($quantity[$i])){
                for($i2 = 0; $i2<$quantity[$i]; $i2++){
                    $size = Request::input('group'.$menus_id[$i]);
                    Store::setUsersOrder($order_id, $user_id, $menus_id[$i], $size, $memo[$i]);
                }
            }
        }
        return Redirect::route('order');
    }

    public function delStoreAndTheMenu(){
        $id = $_POST['id'];
        return Store::delStoreAndTheMenu($id);
    }

    public function delOneMenu(){
        $id = $_POST['id'];
        return Store::delOneMenu($id);
    }

    public function delOrder(){
        $id = $_POST['id'];
        return Store::delOrder($id);
    }

    public function checkStoreTel(){
        $tel = $_POST['tel'];
        return Store::checkStoreTel($tel);
    }

    public function checkStoreName(){
        $name = $_POST['name'];
        return Store::checkStoreName($name);
    }

}
