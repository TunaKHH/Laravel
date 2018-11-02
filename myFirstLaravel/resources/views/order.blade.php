@extends('layouts.app') @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">訂單管理</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-order" role="tabpanel" aria-labelledby="order-tab">
                            <?php if($_SESSION['userPermission'] == '0'){
                                    ?>
                                <?php echo Form::open(array('action' => 'HomeController@setNewOrder', 'id' => 'setNewOrder'))?>
                                    <div class="row">
                                        <div class="col">
                                            <input name="order_name" id="order_name" type="text" class="form-control"
                                                placeholder="訂單名稱">
                                        </div>
                                        <div class="col">
                                            <select name="order_store" id="order_store" class="form-control">
                                                <option selected>請選擇店家</option>
                                                @foreach($stores as $store)
                                                <option value="{{ $store->id }}">
                                                    {{ $store->name }}
                                                </option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="col">
                                            <button type="button" class="btn-addOrder btn btn-primary">
                                                新增</button>
                                        </div>
                                    </div>
                                {{ Form::close() }}
                            <?php
                                }?>
                            <br />
                            <div class="container">
                                <table id="order_datatable" class="table table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <?php if($_SESSION['userPermission'] == '0'){?>
                                                <th scope="col">刪除</th>
                                            <?php }?>
                                            <th scope="col">加訂</th>
                                            <th scope="col">檢視</th>
                                            <?php if($_SESSION['userPermission'] == '0'){?>
                                                <th scope="col">Lock</th>
                                            <?php }?>
                                            <th scope="col">訂單名稱</th>
                                            <th scope="col">主揪</th>
                                            <th scope="col">店家</th>
                                            <th scope="col">類型</th>
                                            <th scope="col">開單時間</th>
                                            <th scope="col">店家電話</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders as $order)
                                        <tr>
                                            <?php if($_SESSION['userPermission'] == '0'){
                                                ?>
                                                <td scope="col">
                                                    <button value="{{$order->orderId}}" type="button" class="btn_delOrder btn btn-danger btn-sm">
                                                        <i class="far fa-trash-alt fa-xs"></i>
                                                    </button>
                                                </td>
                                            <?php
                                            }?>
                                            <td>
                                                @if($order->lock_type)
                                                <button type="button" data-toggle="modal" alt="此訂單已上鎖！"
                                                    class="btn btn-danger btn-sm" disabled/>
                                                        <i class="fas fa-ban fa-xs"></i>
                                                    <input value="{{$order->store_id}}" hidden>
                                                </button>
                                                @else
                                                <button value="{{$order->orderId}}" type="button" data-toggle="modal"
                                                    class="btn_addOrderDetail btn btn-success btn-sm">
                                                        <i class="fas fa-plus fa-xs"></i>
                                                    <input value="{{$order->store_id}}" hidden>
                                                </button>
                                                @endif
                                            </td>
                                            <td scope="col">
                                                <button value="{{$order->orderId}}" style="color:#ffffff" type="button" class="btn_viewOrder btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>

                                            <?php if($_SESSION['userPermission'] == '0'){
                                                ?>
                                                <td>
                                                    <button value="{{$order->orderId}}" type="button" class="btn_setLock btn btn-dark btn-sm">
                                                        @if($order->lock_type)
                                                        <i class="fas fa-lock fa-xs"></i>
                                                        @else
                                                        <i class="fas fa-lock-open fa-xs"></i>
                                                        @endif
                                                        <input value="{{$order->lock_type}}" type="hidden">
                                                    </button>
                                                </td>
                                            <?php
                                            }?>
                                            <td class="row_view_orders" value="{{$order->orderId}}">{{ $order->orderName }}</td>
                                            <td class="row_view_orders" value="{{$order->orderId}}">{{ $order->userName }}</td>
                                            <td class="row_view_orders" value="{{$order->orderId}}">{{ $order->storeName }}</td>
                                            <td class="row_view_orders" value="{{$order->orderId}}">
                                                @if($order->type == 0) 飲料 @elseif($order->type == 1) 便當 @endif
                                            </td>
                                            <td class="row_view_orders" value="{{$order->orderId}}">{{ $order->updated_at }}</td>
                                            <td class="row_view_orders" value="{{$order->orderId}}">{{ $order->telphone }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!--add Order Modal-->
                    <div class="modal fade" id="addOrderModal" tabindex="-1" role="dialog" aria-labelledby="addOrderModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary" style="color: #ffffff">
                                    <h5 class="modal-title" >Order點餐介面</h5>
                                    <button style="color: #ffffff" type="button" class="close" data-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <?php echo Form::open(array('action' => 'HomeController@setUsersOrder', 'id' => 'setUsersOrder'))?>
                                <input name="user_id" value="<?php echo $userId?>" hidden>
                                <div class="modal-body">
                                    <input id="order_id" name="order_id" hidden>
                                    <div class="accordion" id="accordionExample">
                                        <div class="card">
                                            <div class="card-header" id="headingOne">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link" type="button" data-toggle="collapse"
                                                        data-target="#collapseOne" aria-expanded="true"
                                                        aria-controls="collapseOne">
                                                        尚未分類
                                                    </button>
                                                </h5>
                                            </div>

                                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                                data-parent="#accordionExample">
                                                <div class="card-body">
                                                    <table class="table table-striped table-light">
                                                        <thead>
                                                            <tr>
                                                                <!--<th scope="col" rowspan="2">#</th>-->
                                                                <th scope="col" rowspan="2">餐點品項</th>
                                                                <th scope="col" colspan="3" style="text-align:center;">價格</th>
                                                                <th scope="col" rowspan="2">數量</th>
                                                                <th scope="col" rowspan="2">備註</th>
                                                            </tr>
                                                            <tr>
                                                                <th>小</th>
                                                                <th>中</th>
                                                                <th>大</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="add_menu_item">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                                    <button type="submit" class="btn btn-danger" id="addMenu_submit">送出</button>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>

                    <!-- view user's order list -->
                    <div class="modal fade" id="viewUsersOrderModal" tabindex="-1" role="dialog" aria-labelledby="viewUsersOrderLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary" style="color: #ffffff">
                                    <h5 class="modal-title" id="exampleModalLabel">檢視菜單</h5>
                                    <button style="color: #ffffff" type="button" class="close" data-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <input type="hidden" name="id" id="addMenu_id">
                                        <div class="form-group">
                                            <label for="store-name" class="control-label">店家名稱:</label>
                                            <input type="text" class="form-control" id="addMenu_storeName" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">店家電話:</label>
                                            <input type="text" name="setStoreTel2" class="form-control" id="addMenu_storeTel"
                                                disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="setStoreType" class="control-label">商店類型</label>
                                            <select id="addMenu_storeType" class="form-control" disabled>
                                                <option value="0">飲料店</option>
                                                <option value="1" selected>便當店</option>
                                            </select>
                                        </div>
                                        <br>
                                        <div class="form-group" style="text-align: center;">
                                            <table class="table table-borderless">
                                                <tbody>
                                                    <tr class="row">
                                                        <td class="col-1"></td>
                                                        <td class="col-3">
                                                            <!-- <div class="row">
                                                                <label class="switch">
                                                                    <input type="checkbox" id="switch">
                                                                    <span class="slider round"></span>
                                                                </label>
                                                            </div> -->
                                                        </td>
                                                        <td class="col-4">
                                                            <label class="control-label h3">已訂購訂單</label>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="row top-buffer">
                                                <div class="col">
                                                    品名
                                                </div>
                                                <div class="col">
                                                    SIZE
                                                </div>
                                                <div class="col">
                                                    價格
                                                </div>
                                                <div class="col">
                                                    買方
                                                </div>
                                                <div class="col">
                                                    備註
                                                </div>
                                                <div class="col">

                                                </div>
                                            </div>
                                            <div id="addItem2"></div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button id="btn_print" type="button" class="btn btn-warning" style="background: #FF9800;border-color: #FF9800; color: white;">列印</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("body").delegate('#order_datatable tr .btn_delOrder', 'click', function () {
            var id = $(this).attr('value');
            swal("確認要刪除訂單？", {
                title: "Are you sure?",
                text: "刪除後，您將無法回復此操作！",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDoSomething) => {
                if (willDoSomething) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        url: "delOrder",
                        data: {
                            id: id
                        },
                        dataType: "json",
                        success: function (response) {
                            if (response == true) {
                                swal("刪除成功！", {
                                        icon: "success",
                                        button: "OK",
                                    })
                                    .then((willDoSomething) => {
                                        location.reload()
                                    });
                            } else {
                                console.log('error');
                                console.log(response);
                            }
                        },
                        error: function (response) {
                            console.log(response);
                            // console.log('error');
                        }
                    });

                } else {
                    swal("刪除取消，您的操作未被執行！", {
                        icon: "error",
                    })
                }
            });
        });

        $("body").delegate('#order_datatable tr .btn_addOrderDetail', 'click', function () {
             //加訂按鈕被點擊
             let order_id = $(this).attr('value');
            let store_id = $(this).children('input').attr('value');
            let day = $(this).parent().parent().children("td")[3].textContent;
            let store_name = $(this).parent().parent().children("td")[5].textContent;
            $('#add_menu_item').children().remove();
            $('.modal-title').text(day + store_name);
            $('#order_id').val(order_id);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                url: "getTheStoreAndMenuListByTheStore",
                data: {
                    id: store_id
                },
                dataType: "json",
                success: function (response) {
                    let html = '';
                    response.forEach(function (item, index) {
                        if ((item['price_s'] == 0 && item['price_m'] == 0) || (item[
                                'price_m'] == 0 && item['price_l'] == 0) || (item[
                                'price_s'] == 0 && item['price_l'] == 0)) {
                            html = '<tr>' +
                                '<td>' + item['mname'] + '</td>' +
                                '<td></td>' +
                                '<td>' +
                                item['price_s'] != 0 ? item['price_s'] : item['price_m'] != 0 ? item['price_m'] : item['price_l'] + '</td>' +
                                '<td></td>' +
                                '<td>' +
                                '<div class="input-group">' +
                                '<input type="number" aria-label="Last name" class="form-control">' +
                                '</div>' +
                                '</td>' +
                                '<td>' +
                                '<div class="input-group">' +
                                ' <input type="text" aria-label="Last name" class="form-control">' +
                                '</div>' +
                                '</td>';
                        } else {

                        }

                        html =
                            `<tr>
                                <!--<td scope="row">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input">
                                        <span class="custom-control-indicator"></span>
                                    </label>
                                </td>-->
                                <td>
                                    <input value="${item['mid']}" name="mid[]" hidden>
                                    ${item['mname']}
                                </td>
                                <td>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" value="S" class="price form-check-input" name="group${item['mid']}" ${item['price_s'] == 0?'disabled':item['price_s']}>
                                            ${item['price_s']}
                                        </label>
                                    </div>
                                </td>
                                <td >
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" value="M" class="price form-check-input" name="group${item['mid']}" ${item['price_m'] == 0?'disabled':item['price_m']}>
                                            ${item['price_m']}
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" value="L" class="price form-check-input" name="group${item['mid']}" ${item['price_l'] == 0?'disabled':item['price_l']}>
                                            ${item['price_l']}
                                        </label>
                                    </div>
                                </td>
                                <td >
                                    <div class="input-group">
                                        <input type="number" aria-label="Last name" name="num[]" class="num form-control">
                                    </div>
                                </td>
                                <td >
                                    <div class="input-group">
                                        <input type="text" aria-label="Last name" name="memo[]" class="memo form-control">
                                    </div>
                                </td>
                            </tr>`;
                        $('#add_menu_item').append(html);
                    });
                    $('#addOrderModal').modal('show');

                    $(".price").click(function () {//當價格被點擊時數量更改為1
                        var item = $(this).parents('tr').find('.num').val('1');
                    });

                    $('.num').focus(function (e) {
                        e.preventDefault();
                        var item = $(this).parents('tr').find('.price')[2].click();
                    });

                },
                error: function (response) {
                    console.log(response);
                }
            });
        });

        $("body").delegate('#order_datatable tr .btn_setLock', 'click', function () {
            var id = $(this).attr('value');
            var lock_type = $(this).children('input').attr('value');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "setOrderLock",
                method: "post",
                data: {
                    id: id,
                    lock_type: lock_type
                },
                type: "post",
                dataType: "json",
                success: function (response) {
                    location.reload();
                },
                error: function (response) {

                }
            });
        });

        $('#order_datatable').DataTable();
        var NowDate = new Date();
        var Today = NowDate.getFullYear() + '-' + (NowDate.getMonth() + 1) + '-' + NowDate.getDate();
        $('#order_name').val(Today);

        var userId = "<?php echo $userId?>";
        var id;

        $('.row_view_orders, .btn_viewOrder').click(function (e) {
            e.preventDefault();
            id = $(this).attr('value');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: 'getAllUsersOrderList',
                method: 'POST',
                data: {
                    id: id
                },
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                    $("#addItem2").children().remove();
                    $('#addMenu_storeName').val(data[0].store_name);
                    $('#addMenu_storeTel').val(data[0].store_telphone);
                    $('#addMenu_storeType').val(data[0].store_type);
                    if (typeof (data[0].menu_name) != 'undefined') {
                        let userPermission = "<?php echo $_SESSION['userPermission']?>";
                        let lock_type = "{{$order->lock_type}}";
                        if(userPermission == 0 && lock_type == 0){
                            for (var i = 0; i < data.length; i++) {
                                var html2 =
                                    '<div class="row top-buffer">' +
                                        '<div class="col">' +
                                            '<input value="' + data[i].menu_name +
                                            '" type="text" class="edit_mname form-control" placeholder="品項名稱" disabled>' +
                                        '</div>' +
                                        '<div class="col">' +
                                            '<input value="' + data[i].size +
                                            '"  class="edit_price_s form-control" disabled>' +
                                        '</div>' +
                                        '<div class="col">' +
                                            '<input value="' + (data[i].size =='S'?data[i].price_s : data[i].size =='M'?data[i].price_m : data[i].price_l) +
                                            '" type="number" class="edit_price_m form-control" disabled>' +
                                        '</div>' +
                                        '<div class="col">' +
                                            '<input value="' + data[i].name +
                                            '" class="edit_price_l form-control" disabled>' +
                                        '</div>' +
                                        '<div class="col">' +
                                            '<input value="' + (data[i].memo == null ? '' : data[i].memo) +
                                            '" class="edit_price_l form-control" disabled>' +
                                        '</div>' +
                                        '<div class="col">' +
                                            '<button type="button" class="btn_edit_del btn btn-danger" value="' +
                                            data[i].users_orders_id + '" >' +
                                                '<i class="fas fa-minus"></i>' +
                                            '</button>' +
                                        '</div>' +
                                    '</div>';

                                $("#addItem2").append(html2);
                            }
                        }else{
                            for (var i = 0; i < data.length; i++) {
                                var html2 =
                                    '<div class="row top-buffer">' +
                                        '<div class="col">' +
                                            '<input value="' + data[i].menu_name +
                                            '" type="text" class="edit_mname form-control" placeholder="品項名稱" disabled>' +
                                        '</div>' +
                                        '<div class="col">' +
                                            '<input value="' + data[i].size +
                                            '"  class="edit_price_s form-control" disabled>' +
                                        '</div>' +
                                        '<div class="col">' +
                                            '<input value="' + (data[i].size =='S'?data[i].price_s : data[i].size =='M'?data[i].price_m : data[i].price_l) +
                                            '" type="number" class="edit_price_m form-control" disabled>' +
                                        '</div>' +
                                        '<div class="col">' +
                                            '<input value="' + data[i].name +
                                            '" class="edit_price_l form-control" disabled>' +
                                        '</div>' +
                                        '<div class="col">' +
                                            '<input value="' + (data[i].memo == null ? '' : data[i].memo) +
                                            '" class="edit_price_l form-control" disabled>' +
                                        '</div>'+
                                    '</div>';

                                $("#addItem2").append(html2);
                            }
                        }
                    }

                    $('#viewUsersOrderModal').modal('show');

                    $('.btn_edit_del').click(function () {
                        let id = $(this).attr('value');
                        swal({
                            title: "Are you sure?",
                            text: "刪除後，您將無法回復此操作！",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        })
                        .then((willDelete) => {
                            if (willDelete) {
                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    url: 'delUsersOrdersItem',
                                    method: 'POST',
                                    data: {
                                        id: id
                                    },
                                    type: 'POST',
                                    dataType: 'json',
                                    success: function (data) {
                                        swal("刪除成功！", {
                                            icon: "success",
                                            button: "OK",
                                        })
                                        .then((willDelete) => {
                                                location.reload()
                                            }

                                        );
                                    },
                                    error: function (data) {
                                        console.log('error');
                                        swal("刪除失敗！請洽系統管理員", {
                                            icon: "error",
                                            button: "OK",
                                        })
                                        .then((willDelete) => {
                                                location.reload()
                                            }

                                        );
                                    }
                                })

                            } else {
                                swal("刪除取消，您的操作未被執行!", {
                                    icon: "error",
                                });
                            }
                        });
                    });

                    $(document).on('blur', '.setClassifyName', function () {
                        var name = $(this).val();
                        if (name != "") {
                            console.log(name);
                        }
                    })
                },
                error: function (data) {
                    console.log('error');
                }
            })
        });

        $('#btn_print').click(function () {
            let href = './print?id=' + id;
            window.location.href = href;
            // console.log(href);
        });

        $(".btn-addOrder").click(function () {
            var order_name = $("#order_name").val();
            var order_store = $("#order_store").val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "setNewOrder",
                data: {
                    userId: userId,
                    name: order_name,
                    store: order_store
                },
                dataType: "json",
                success: function (response) {
                    if (response == true) {
                        swal("新增訂單成功！", {
                                icon: "success",
                                button: "OK",
                            })
                            .then((willDoSomething) => {
                                location.reload()
                            });
                    } else {
                        console.log('error');
                        console.log(response);
                    }
                },
                error: function (response) {
                    console.log(response);
                }
            });
        });

        $('.btn_editStore').click(function () {
            var id = $(this).attr('value');
        });



        function del() {
            $(".del").click(function () {
                $(this).parent().parent().remove();
            })
        }

    });

</script>
@endsection