@extends('layouts.app') @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">權限管理</div>

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
                                            <th scope="col">修改權限</th>
                                            <th scope="col">帳號</th>
                                            <th scope="col">姓名</th>
                                            <th scope="col">權限</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                        <tr>
                                            <th scope="col">
                                                <button value="{{$user->id}}" type="button" class="btn_editPer btn btn-danger btn-sm">
                                                    <i class="fas fa-wrench fa-xs"></i>
                                                </button>
                                            </th>
                                            <th scope="col">{{$user->email}}</th>
                                            <th scope="col">{{$user->name}}</th>
                                            <th scope="col">
                                                @if($user->permission)
                                                    一般使用者
                                                @else
                                                    管理員
                                                @endif
                                            </th>
                                        </tr>
                                        @endforeach
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var NowDate = new Date();
        var Today = NowDate.getFullYear() + '-' + (NowDate.getMonth() + 1) + '-' + NowDate.getDate();
        $('#order_name').val(Today);

        var userId = "<?php echo $userId?>";

        $('.btn_editPer').click(function (e) {
            let id = $(this).attr('value');
            e.preventDefault();
            swal({
                title: "Are you sure?",
                text: "確定要更改此使用者的權限嗎？",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: 'setEditUserPermission',
                        method: 'POST',
                        data: {
                            id: id
                        },
                        type: 'POST',
                        dataType: 'json',
                        success: function (data) {
                            swal("更改成功！", {
                                    icon: "success",
                                    button: "OK",
                                })
                                .then((willDelete) => {
                                        location.reload()
                                    }

                                );
                        },
                        error: function (data) {
                            console.log(data);
                            swal("更改失敗！", {
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