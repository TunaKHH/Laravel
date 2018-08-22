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
                            <button data-toggle="modal" data-target="#addStoreModal" type="button" class="btn-showStoreModal btn btn-primary">新增</button>
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
                                                    <i class="fas fa-archway"></i>
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
                        <div class="tab-pane fade" id="pills-menu" role="tabpanel" aria-labelledby="pills-menu-tab">menuPage</div>
                        <div class="tab-pane fade" id="pills-authority" role="tabpanel" aria-labelledby="pills-authority-tab">authorityPage</div>
                        <div class="tab-pane fade" id="pills-track" role="tabpanel" aria-labelledby="pills-track-tab">trackPage</div>
                    </div>
                    <!--Add Store Modal -->
                    <?php echo Form::open(array('action' => 'HomeController@setNewStore', 'id' => 'addStoreForm'))?>
                    <div class="modal fade" id="addStoreModal" tabindex="-1" role="dialog" aria-labelledby="addStoreModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary" style="color: #ffffff">
                                    <h5 class="modal-title" id="exampleModalLabel">新增店家</h5>
                                    <button style="color: #ffffff" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="store-name" class="control-label">店家名稱:</label>
                                            <input type="text" class="form-control" id="addStore_storeName" name="setStoreName" data-focus="false" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="store-tel" class="control-label">店家電話:</label>
                                            <input type="text" class="form-control" id="store-tel" name="setStoreTel" value="test" required>
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
                                                        <td class="col-2"></td>
                                                        <td class="col-8">
                                                            <label for="store-tel" class="control-label h3 ">菜單管理</label>
                                                        </td>
                                                        <td class="col-2">
                                                            <button type="button" class="add btn btn-primary">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <div class="row">
                                                <div class="col-5">
                                                    <input value="111" name="setProductName[]" type="text" class="form-control" placeholder="品項名稱" required>
                                                </div>
                                                <div class="col-2">
                                                    <input value="111" name="setPriceS[]" type="number" class="form-control" placeholder="價格(小)" required>
                                                </div>
                                                <div class="col-2">
                                                    <input value="111" name="setPriceM[]" type="number" class="form-control" placeholder="價格(中)" required>
                                                </div>
                                                <div class="col-2">
                                                    <input value="111" name="setPriceL[]" type="number" class="form-control" placeholder="價格(大)" required>
                                                </div>
                                            </div>
                                            <br>

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

                    <!--Add Menu Modal -->
                    <?php echo Form::open(array('action' => 'HomeController@setNewMenu', 'id' =>'addMenuForm'))?>
                    <div class="modal fade" id="addMenuModal" tabindex="-1" role="dialog" aria-labelledby="addMenuModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary" style="color: #ffffff">
                                    <h5 class="modal-title" id="exampleModalLabel">新增/管理菜單</h5>
                                    <button style="color: #ffffff" type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                                            <label for="store-tel" class="control-label">店家電話:</label>
                                            <input type="text" name="setStoreTel2" class="form-control" id="addMenu_storeTel" disabled>
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
                                                            <div class="row">
                                                                <label class="switch">
                                                                    <input type="checkbox">
                                                                    <span class="slider round"></span>
                                                                </label>
                                                            </div>

                                                        </td>
                                                        <td class="col-4">
                                                            <label for="store-tel" class="control-label h3 ">菜單管理</label>
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
                                    <button type="button" class="btn btn-danger" id="addMenu_submit">送出</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                    <!--Edit Menu Modal -->
                    <!-- <div class="modal fade " id="editMenuModal" tabindex="-1" role="dialog" aria-labelledby="editMenuModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">修改菜單</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="store-name" class="control-label">店家名稱:</label>
                                            <input type="text" class="form-control" id="store-name">
                                        </div>
                                        <div class="form-group">
                                            <label for="store-tel" class="control-label">店家電話:</label>
                                            <input type="text" class="form-control" id="store-tel">
                                        </div>

                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                                    <button type="button" class="btn btn-danger" id="submit">送出</button>
                                </div>
                            </div>
                        </div>
                    </div> -->
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
        var html = '<div class="row top-buffer">' +
            '<div class="col-5">' +
            '<input name="setProductName[]" type="text" class="form-control" placeholder="品項名稱" required>' +
            '</div>' +
            '<div class="col-2">' +
            '<input name="setPriceS[]" type="number" class="form-control" placeholder="價格(小)" required>' +
            '</div>' +
            '<div class="col-2">' +
            '<input name="setPriceM[]" type="number" class="form-control" placeholder="價格(中)" required>' +
            '</div>' +
            '<div class="col-2">' +
            '<input name="setPriceL[]" type="number" class="form-control" placeholder="價格(大)" required>' +
            '</div>' +
            '<div class="col-1">' +
            '<button class="del btn btn-danger">' +
            '<i class="fas fa-minus"></i>' +
            '</button>' +
            '</div>' +
            '</div>';
        $(".add").click(function () {
            $("#addItem").append(html);
            del();
        })

        $(".add2").click(function () {
            $("#addItem2").prepend(html);
            del();
        })

        $(".addStoreForm_submit").click(function () {
            $("#addStoreForm").submit();
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
                            var html2 = '<div class="row top-buffer">' +
                                '<div class="col-5">' +
                                '<input value="' + data[i].mname +
                                '" type="text" class="form-control" placeholder="品項名稱" disabled>' +
                                '</div>' +
                                '<div class="col-2">' +
                                '<input value="' + data[i].price_s +
                                '" type="number" class="form-control" placeholder="價格(小)" disabled>' +
                                '</div>' +
                                '<div class="col-2">' +
                                '<input value="' + data[i].price_m +
                                '" type="number" class="form-control" placeholder="價格(中)" disabled>' +
                                '</div>' +
                                '<div class="col-2">' +
                                '<input value="' + data[i].price_l +
                                '" type="number" class="form-control" placeholder="價格(大)" disabled>' +
                                '</div>' +
                                '<div class="col-1">' +
                                '</div>' +
                                '</div>';

                            $("#addItem2").append(html2);
                        }
                    }

                    $("#addItem2").prepend(html);
                    $('#addMenuModal').modal('show');
                    $('#addMenu_submit').click(function () {

                        if (confirm("確定要新增嗎?")) {
                            $('#addMenuForm').submit();
                        }
                    });
                },
                error: function (data) {
                    console.log('error');
                }
            })
        });

        // $('.btn-showStoreModal').click(function(){
        //     if($('#addStoreModal').css("display") == "block"){
        //         $('#addStore_storeName').focus();
        //         console.log(1)
        //     }
        //     console.log($('#addStoreModal').css("display"));
        // })

        $('#addStoreModal').on('shown.bs.modal', function (e) {
            $('#addStore_storeName').focus();
        })

        $('.btn_editStore').click(function () {
            var id = $(this).attr('value');
            $.ajax({
                url: 'getOneStore',
                method: 'POST',
                data: {
                    id: id
                },
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                    $('#store-name').val(data.name);
                    $('#store-tel').val(data.tel);
                    $('#submit').click(function () {
                        $.ajax({
                            url: 'setEditStore',
                            method: 'POST',
                            data: {
                                id: id
                            },
                            type: 'POST',
                            dataType: 'json',
                            success: function (data) {
                                $('#store-name').val(data.name);
                                $('#store-tel').val(data.tel);

                            },
                            error: function (data) {
                                console.log('error');
                            }
                        })
                    });
                },
                error: function (data) {
                    console.log('error');
                }
            })
        });
    });

</script>
@endsection
