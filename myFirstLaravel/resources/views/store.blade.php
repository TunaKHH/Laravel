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
                            <button data-toggle="modal" data-target="#addMenuModal" type="button" class="btn btn-primary">新增</button>
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
                            <div class="row">
                                <table class="table table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">刪除</th>
                                            <th scope="col">修改</th>
                                            <th scope="col">店家名稱</th>
                                            <th scope="col">電話</th>
                                            <th scope="col">類型</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($stores as $store)
                                        <tr>
                                            <td scope="row">
                                                <button value="{{$store->id}}" type="button" class="btn_delStore btn btn-danger btn-sm">
                                                    <i class="far fa-trash-alt fa-xs"></i>
                                                </button>
                                            </td>
                                            <td>
                                                <button value="{{$store->id}}" type="button" class="btn_editStore btn btn-warning btn-sm" style="background-color: #ffc107;border-color: #ffc107;color: #ffffff;"
                                                    data-toggle="modal" data-target="#editMenuModal">
                                                    <i class="far fa-edit fa-xs"></i>
                                                </button>
                                            </td>
                                            <td>{{ $store->name }}</td>
                                            <td>{{ $store->telphone }}</td>

                                            @if($store->type == 0)
                                            <td>飲料</td>
                                            @elseif($store->type == 1)
                                            <td>便當</td>
                                            @endif
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
                    <?php echo Form::open(array('action' => 'HomeController@setNewStore', 'id' => 'addForm'))?>
                    <div class="modal fade" id="addMenuModal" tabindex="-1" role="dialog" aria-labelledby="addMenuModalLabel" aria-hidden="true">
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
                                            <input type="text" class="form-control" id="store-name" name="setStoreName" value="test" required>
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
                                            <label for="store-tel" class="control-label h3 ">菜單管理</label>
                                            <div class="col" style="text-align: right;">
                                                <button class="add btn btn-primary"><i class="fas fa-plus"></i></button>
                                            </div>                                           
                                            
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
                                    <button type="submit" class="btn btn-danger" id="submit">送出</button>
                                </div>
                            </div>
                        </div>
                    </div>                    
                    {{ Form::close() }}
                    
                    <!--Add Menu Modal -->
                    <?php echo Form::open(array('action' => 'HomeController@setNewStore', 'id' => 'addForm'))?>
                    <div class="modal fade" id="addMenuModal" tabindex="-1" role="dialog" aria-labelledby="addMenuModalLabel" aria-hidden="true">
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
                                            <input type="text" class="form-control" id="store-name" name="setStoreName" value="test" required>
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
                                            <label for="store-tel" class="control-label h3 ">菜單管理</label>
                                            <div class="col" style="text-align: right;">
                                                <button class="add btn btn-primary"><i class="fas fa-plus"></i></button>
                                            </div>                                           
                                            
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
                                    <button type="submit" class="btn btn-danger" id="submit">送出</button>
                                </div>
                            </div>
                        </div>
                    </div>                    
                    {{ Form::close() }}
                    <!--Edit Menu Modal -->
                    <div class="modal fade " id="editMenuModal" tabindex="-1" role="dialog" aria-labelledby="editMenuModalLabel" aria-hidden="true">
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
        var html = '<div class="row">'+
                        '<div class="col-5">'+
                            '<input name="setProductName[]" type="text" class="form-control" placeholder="品項名稱" required>'+
                        '</div>'+
                        '<div class="col-2">'+
                            '<input name="setPriceS[]" type="number" class="form-control" placeholder="價格(小)" required>'+
                        '</div>'+
                        '<div class="col-2">'+
                            '<input name="setPriceM[]" type="number" class="form-control" placeholder="價格(中)" required>'+
                        '</div>'+
                        '<div class="col-2">'+
                            '<input name="setPriceL[]" type="number" class="form-control" placeholder="價格(大)" required>'+
                        '</div>'+
                        '<div class="col-1">'+
                            '<button class="del btn btn-danger">'+
                                '<i class="fas fa-minus"></i>'+
                            '</button>'+
                        '</div>'+
                    '</div>'+
                    '<br>';
        $(".add").click(function(){
            $("#addItem").append(html);
            del();
        })

        function del(){
            $(".del").click(function(){
                $(this).parent().parent().remove();
            })
        }        

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
    // $(document).ready(function () {
    //             $(".view_news").click(function () {
    //                 var id = $(this).attr('id');
    //                 // console.log(id);
    //                 $.ajax({ //傳值給news.php
    //                     url: './news.php',
    //                     method: 'POST', //資料'傳遞'的送出方式
    //                     data: { //送出的資料
    //                         action: 'get_news_detail',
    //                         id: id
    //                     },
    //                     type: "POST", //資料'傳遞'的接收方式
    //                     dataType: 'json', //資料內容型態
    //                     success: function (data) {
    //                         $(".modal-title").text(data.title);
    //                         $(".modal-body").html(data.content);
    //                         $("#myModal").modal();
    //                     }
    //                 })
    //             });
    //         });

</script>
@endsection
