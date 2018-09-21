@extends('layouts.app') @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">訂購紀錄</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-order" role="tabpanel" aria-labelledby="order-tab">
                            <br />
                            <div class="row">
                                <table class="table table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">訂購名稱</th>
                                            <th scope="col">主揪</th>
                                            <th scope="col">日期</th>
                                            <th scope="col">花費</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="col">訂購名稱</th>
                                            <th scope="col">主揪</th>
                                            <th scope="col">日期</th>
                                            <th scope="col">花費</th>
                                        </tr>
                                    </tbody>
                                </table>
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
        var NowDate = new Date();
        var Today = NowDate.getFullYear() + '-' + (NowDate.getMonth() + 1) + '-' + NowDate.getDate();
        $('#order_name').val(Today);

        var userId = "<?php echo $userId?>";

        $('.row_view_orders').click(function (e) {
            e.preventDefault();
            let id = $(this).attr('value');

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
                                        '<input value="' + data[i].memo +
                                        '" class="edit_price_l form-control" disabled>' +
                                    '</div>' +
                                    '<div class="col">' +
                                        '<button type="button" class="btn_edit_del btn btn-danger" value="' +
                                        data[i].mid + '" >' +
                                            '<i class="fas fa-minus"></i>' +
                                        '</button>' +
                                    '</div>' +
                                '</div>';

                            $("#addItem2").append(html2);
                        }
                    }

                    $('#viewUsersOrderModal').modal('show');

                    $('.btn_edit_del').click(function () {
                        var id = $(this).attr('value');
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
                                    url: 'delOneMenu',
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

        $('.btn_delOrder').click(function () {
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

        $('.btn_addOrderDetail').click(function () { //加訂按鈕被點擊
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
                                <td scope="row">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input">
                                        <span class="custom-control-indicator"></span>
                                    </label>
                                </td>
                                <td>
                                    <input value="${item['mid']}" name="mid[]" hidden>
                                    ${item['mname']}
                                </td>
                                <td>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" value="S" class="price form-check-input" name="group${item['mid']}" >
                                            ${item['price_s']}
                                        </label>
                                    </div>
                                </td>
                                <td >
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" value="M" class="price form-check-input" name="group${item['mid']}">
                                            ${item['price_m']}
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" value="L" class="price form-check-input" name="group${item['mid']}">
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

                },
                error: function (response) {
                    console.log(response);
                }
            });



        });

        $(".btn_setLock").click(function () {
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

        function del() {
            $(".del").click(function () {
                $(this).parent().parent().remove();
            })
        }

    });

</script>
@endsection