@extends('layouts.app') @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="h4 col">
                            店家管理
                        </div>
                        <div class="col" style="text-align: end;">
                            <button data-toggle="modal" data-target="#addStoreModal" data-backdrop="static"
                                data-keyboard="false" type="button" class="btn-showStoreModal btn btn-primary">新增</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-store">
                            <br>
                            <div class="container">
                                <table class="table table-striped">
                                    <thead class="thead-dark">
                                        <tr class="row">
                                            <th class="col-2">刪除</th>
                                            <th class="col-2">新增/管理菜單</th>
                                            <th class="col-5">店家名稱</th>
                                            <th class="col-2">電話</th>
                                            <th class="col-1">類型</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($stores as $store)
                                        <tr class="row">
                                            <td class="col-2">
                                                <button value="{{$store->id}}" type="button" class="btn_delStore btn btn-danger btn-sm">
                                                    <i class="far fa-trash-alt fa-xs"></i>
                                                </button>
                                            </td>
                                            <td class="col-2">
                                                <button value="{{$store->id}}" type="button" class="btn_addMenu btn btn-primary btn-sm">
                                                    <i class="fas fa-wrench fa-xs"></i>
                                                </button>
                                            </td>
                                            <td class="col-5">{{ $store->name }}</td>
                                            <td class="col-2">{{ $store->telphone }}</td>
                                            <td class="col-1">
                                                @if($store->type == 0) 飲料 @elseif($store->type == 1) 便當 @endif
                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <!--Add Store Modal -->
                    <?php echo Form::open(array('action' => 'HomeController@setNewStore', 'id' => 'addStoreForm'))?>
                    <div class="modal fade" id="addStoreModal" tabindex="-1" role="dialog" aria-labelledby="addStoreModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary" style="color: #ffffff">
                                    <h5 class="modal-title" id="exampleModalLabel">新增店家</h5>
                                    <button style="color: #ffffff" type="button" class="close" data-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="store-name" class="control-label">店家名稱:</label>
                                            <input type="text" class="form-control" id="addStore_storeName" name="setStoreName"
                                                data-focus="false" required>
                                            <div class="valid-feedback">
                                                Looks good!店家名稱沒重複!
                                            </div>
                                            <div class="invalid-feedback">
                                                Oops!店家名稱重複囉!
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="addStore_storeTel" class="control-label">店家電話:</label>
                                            <input type="text" class="form-control" id="addStore_storeTel" name="setStoreTel"
                                                required>
                                            <div class="valid-feedback">
                                                Looks good!店家電話沒重複!
                                            </div>
                                            <div class="invalid-feedback">
                                                Oops!店家電話重複囉!
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="setStoreType" class="control-label">商店類型</label>
                                            <select name="setStoreType" id="setStoreType" class="form-control">
                                                <!-- <option selected>請選擇商店類型</option> -->
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
                                                            <div class="row">
                                                                <label class="switch">
                                                                    <input type="checkbox">
                                                                    <span class="slider round"></span>
                                                                </label>
                                                            </div>

                                                        </td>
                                                        <td class="col-4">
                                                            <label class="control-label h3 ">菜單管理</label>
                                                        </td>
                                                        <td class="col-2" style="text-align:end;">
                                                            <button type="button" class="add_100 btn btn-dark">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </td>
                                                        <td class="col-2" style="text-align:end;">
                                                            <button type="button" class="add btn btn-primary">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div id="addItem"></div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                                    <button type="button" class="btn btn-danger addStoreForm_submit">送出</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}

                    <!--Edit Modal -->
                    <?php echo Form::open(array('action' => 'HomeController@setNewMenu', 'id' =>'addMenuForm'))?>
                    <div class="modal fade" id="addMenuModal" tabindex="-1" role="dialog" aria-labelledby="addMenuModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary" style="color: #ffffff">
                                    <h5 class="modal-title" id="exampleModalLabel">新增/管理菜單</h5>
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
                                                            <label class="control-label h3">分類管理</label>
                                                        </td>
                                                        <td class="col-4" style="text-align:end;">
                                                            <button type="button" class="add3 btn btn-primary">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div id="addItem3"></div>
                                        </div>
                                        <div class="form-group" style="text-align: center;">
                                            <table class="table table-borderless">
                                                <tbody>
                                                    <tr class="row">
                                                        <td class="col-1"></td>
                                                        <td class="col-3">
                                                            <div class="row">
                                                                <label class="switch">
                                                                    <input type="checkbox" id="switch">
                                                                    <span class="slider round"></span>
                                                                </label>
                                                            </div>

                                                        </td>
                                                        <td class="col-4">
                                                            <label class="control-label h3 ">菜單管理</label>
                                                        </td>
                                                        <td class="col-4" style="text-align:end;">
                                                            <button type="button" class="add2 btn btn-primary">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div id="addItem2"></div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                                    <button type="submit" class="btn btn-danger" id="addMenu_submit">送出</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var switch_type = 0;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var html = '<div class="row top-buffer">' +
            '<div class="col-5">' +
            '<input name="setProductName[]" type="text" class="setProductName form-control" placeholder="品項名稱" required>' +
            '</div>' +
            '<div class="col-2">' +
            '<input name="setPriceS[]" type="number" class="setPriceS form-control" placeholder="價格(小)" >' +
            '</div>' +
            '<div class="col-2">' +
            '<input name="setPriceM[]" type="number" class=" setPriceM form-control" placeholder="價格(中)" >' +
            '</div>' +
            '<div class="col-2">' +
            '<input name="setPriceL[]" type="number" class="setPriceL form-control" placeholder="價格(大)" >' +
            '</div>' +
            '<div class="col-1">' +
            '<button type="button" class="del btn btn-danger">' +
            '<i class="fas fa-minus"></i>' +
            '</button>' +
            '</div>' +
            '</div>';

        var html_classify = '<div class="row top-buffer">' +
            '<div class="col">' +
            '<input type="text" class="setClassifyName form-control" placeholder="分類名稱" >' +
            '</div>' +
            '<div class="col">' +
            '<input type="text" class="setClassifyName form-control" placeholder="分類名稱" >' +
            '</div>' +
            '<div class="col">' +
            '<input type="text" class="setClassifyName form-control" placeholder="分類名稱" >' +
            '</div>' +
            '</div>';

        $(".add").click(function () {
            $("#addItem").prepend(html);
            del();
        })

        $(".add_100").click(function () {
            for (var i = 0; i < 100; i++) {
                $("#addItem").prepend(html);
            }
            del();
        })

        $(".add2").click(function () {
            $("#addItem2").prepend(html);
            del();
        })

        $(".add3").click(function () {
            $("#addItem3").prepend(html_classify);
            del();
        })

        $(".addStoreForm_submit").click(function () {
            $("#addStoreForm").submit();
        })



        $('#addStore_storeTel').blur(function () {
            var tel = $(this).val();
            $.ajax({
                type: "post",
                url: "checkStoreTel",
                data: {
                    tel: tel
                },
                dataType: "json",
                success: function (data) {
                    if (data) {
                        $('#addStore_storeTel').removeClass('is-valid');
                        $('#addStore_storeTel').addClass('is-invalid');
                        $('.addStoreForm_submit').attr('disabled', true);
                    } else {
                        $('#addStore_storeTel').removeClass('is-invalid');
                        $('#addStore_storeTel').addClass('is-valid');
                        $('.addStoreForm_submit').attr('disabled', false);
                    }
                },
                error: function (data) {

                }
            });
        })

        $('#addStore_storeName').blur(function () {
            var storeName = $(this).val();
            $.ajax({
                type: "post",
                url: "checkStoreName",
                data: {
                    name: storeName
                },
                dataType: "json",
                success: function (data) {
                    if (data) {
                        $('#addStore_storeName').removeClass('is-valid');
                        $('#addStore_storeName').addClass('is-invalid');
                        $('.addStoreForm_submit').attr('disabled', true);
                    } else {
                        $('#addStore_storeName').removeClass('is-invalid');
                        $('#addStore_storeName').addClass('is-valid');
                        $('.addStoreForm_submit').attr('disabled', false);
                    }
                },
                error: function (data) {

                }
            });
        })

        function del() {
            $(".del").click(function () {
                $(this).parent().parent().remove();
            })
        }

        $('.btn_delStore').click(function () {

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
                            url: 'delStoreAndTheMenu',
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

        $('.btn_addMenu').click(function () {
            $("#addItem2").children().remove();
            $("#addItem3").children().remove();
            var id = $(this).attr('value');
            $('#addMenu_id').val(id);
            $.ajax({
                url: 'getTheStoreAndMenuListByTheStore',
                method: 'POST',
                data: {
                    id: id
                },
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                    $('#addMenu_storeName').val(data[0].name);
                    $('#addMenu_storeTel').val(data[0].telphone);
                    $('#addMenu_storeType').val(data[0].type);
                    if (typeof (data[0].mname) != 'undefined') {
                        for (var i = 0; i < data.length; i++) {
                            var html2 =
                                '<div class="row top-buffer">' +
                                '<input name="edit_mid[]" value="' + data[i].mid +
                                '" hidden>' +
                                '<div class="col-5">' +
                                '<input name="edit_mname[]" value="' + data[i].mname +
                                '" type="text" class="edit_mname form-control" placeholder="品項名稱" disabled>' +
                                '</div>' +
                                '<div class="col-2">' +
                                '<input name="edit_price_s[]" value="' + data[i].price_s +
                                '" type="number" class="edit_price_s form-control" placeholder="價格(小)" disabled>' +
                                '</div>' +
                                '<div class="col-2">' +
                                '<input name="edit_price_m[]" value="' + data[i].price_m +
                                '" type="number" class="edit_price_m form-control" placeholder="價格(中)" disabled>' +
                                '</div>' +
                                '<div class="col-2">' +
                                '<input name="edit_price_l[]" value="' + data[i].price_l +
                                '" type="number" class="edit_price_l form-control" placeholder="價格(大)" disabled>' +
                                '</div>' +
                                '<div class="col-1">' +
                                '<button type="button" class="btn_edit_del btn btn-danger" value="' +
                                data[i].mid + '" hidden>' +
                                '<i class="fas fa-minus"></i>' +
                                '</button>' +
                                '</div>' +
                                '</div>';

                            $("#addItem2").append(html2);
                        }
                    }

                    $("#addItem2").prepend(html);
                    $("#addItem3").append(html_classify);
                    $('#addMenuModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    })
                    $('#addMenuModal').modal('show');

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

                    //當使用jqury送出時無法彈出swal視窗 button送出時亦同

                    // $('#addMenu_submit').find('[type="submit"]').trigger('click');
                    // $('#addMenu_submit').click(function () {


                    //     swal("新增成功！", {
                    //         icon: "success",
                    //         button: "OK",
                    //     })
                    //     .then((willDoSomething) => {
                    //         $('#addMenuForm').submit();
                    //     });
                    // });
                },
                error: function (data) {
                    console.log('error');
                }
            })
        });

        $('.btn-showStoreModal').click(function () {
            $("#addItem").children().remove();
            $("#addItem").prepend(html);
        })

        $('#addStoreModal').on('shown.bs.modal', function (e) {
            $('#addStore_storeName').focus();
        })

        $('#switch').click(function () {
            if (switch_type == 1)
                switch_type = 0;
            else
                switch_type = 1;

            if (switch_type) { //switch_type = 1為進入編輯模式
                $('#addMenuForm').attr("action", "setEditStoreAndMenu");
                $('#addMenu_storeName').attr("disabled", false);
                $('#addMenu_storeTel').attr("disabled", false);
                $('#addMenu_storeType').attr("disabled", false);
                $('.edit_mname').attr("disabled", false);
                $('.edit_price_s').attr("disabled", false);
                $('.edit_price_m').attr("disabled", false);
                $('.edit_price_l').attr("disabled", false);
                $('.setProductName').attr("disabled", true);
                $('.setPriceS').attr("disabled", true);
                $('.setPriceM').attr("disabled", true);
                $('.setPriceL').attr("disabled", true);
                $('.btn_edit_del').attr("hidden", false);

            } else {
                $('#addMenuForm').attr("action", "setNewMenu");
                $('#addMenu_storeName').attr("disabled", true);
                $('#addMenu_storeTel').attr("disabled", true);
                $('#addMenu_storeType').attr("disabled", true);
                $('.edit_mname').attr("disabled", true);
                $('.edit_price_m').attr("disabled", true);
                $('.edit_price_l').attr("disabled", true);
                $('.edit_price_s').attr("disabled", true);
                $('.setProductName').attr("disabled", false);
                $('.setPriceS').attr("disabled", false);
                $('.setPriceM').attr("disabled", false);
                $('.setPriceL').attr("disabled", false);
                $('.btn_edit_del').attr("hidden", true);
            }
        });

    });

</script>
@endsection
