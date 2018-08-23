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
                        <div class="tab-pane fade show active" id="pills-order" role="tabpanel" aria-labelledby="pills-order-tab">
                            <!-- <button class="btn btn-success" type="button" data-toggle="modal" data-target="#addOrderModal">
                                新增訂單
                            </button>   -->
                            <?php echo Form::open(array('action' => 'HomeController@setNewOrder', 'id' => 'setNewOrder'))?>
                            <div class="row">
                                <div class="col">
                                    <input name="order_name" id="order_name" type="text" class="form-control" placeholder="訂單名稱">
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

                            <br/>
                            <div class="row">
                                <table class="table table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">刪除</th>
                                            <th scope="col">加訂</th>
                                            <th scope="col">Lock</th>
                                            <th scope="col">訂單名稱</th>
                                            <th scope="col">主揪</th>
                                            <th scope="col">店家</th>
                                            <th scope="col">類型</th>
                                            <th scope="col">開單時間</th>
                                            <th scope="col">店家電話</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td scope="row">
                                                <button class="btn btn-danger btn-sm" id="btn_delOrder">
                                                    <i class="far fa-trash-alt fa-xs"></i>
                                                </button>
                                            </td>
                                            <td>
                                                <button class="btn btn-success btn-sm">
                                                    <i class="fas fa-plus fa-xs"></i>
                                                </button>
                                            </td>
                                            <td>
                                                <button class="btn btn-dark btn-sm">
                                                    <i class="fas fa-lock fa-xs"></i>
                                                </button>
                                            </td>
                                            <td>0808父親節快樂</td>
                                            <td>林幼晴</td>
                                            <td>古早湯飯</td>
                                            <td>飲料</td>
                                            <td>2018-08-08 09:13:53</td>
                                            <td>0915251335</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-menu" role="tabpanel" aria-labelledby="pills-menu-tab">menuPage</div>
                        <div class="tab-pane fade" id="pills-authority" role="tabpanel" aria-labelledby="pills-authority-tab">authorityPage</div>
                        <div class="tab-pane fade" id="pills-track" role="tabpanel" aria-labelledby="pills-track-tab">trackPage</div>

                    </div>




                    <!--Add Order Modal -->
                    <div class="modal fade" id="addOrderModal" tabindex="-1" role="dialog" aria-labelledby="addOrderModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">新增訂單</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group row">
                                        <input name="order_name" class="form-control form-control-lg" type="text" placeholder="請輸入訂單名稱">
                                    </div>
                                    <div class="form-group row">
                                        <select name="store" class="form-control form-control-lg">
                                            <option>請選擇店家</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                                    <button type="button" class="btn btn-danger">送出</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Edit Menu Modal -->
                    <div class="modal fade " id="editMenuModal" tabindex="-1" role="dialog" aria-labelledby="editMenuModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">管理菜單</h5>
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
                                            </textarea>
                                        </div>

                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                                    <button type="button" class="btn btn-danger">送出</button>
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
        $(".btn-addOrder").click(function () {            
            var order_name = $("#order_name").val();
            var order_store = $("#order_store").val();
            console.log(order_store);
            $.ajax({
                type: "POST",
                url: "setNewOrder",
                data: {
                    name: order_name,
                    store: order_store
                },
                dataType: "json",
                success: function (response) {
                    if(response == 1){
                        swal("新增訂單成功！", {
                            icon: "success",
                            button: "OK",
                        });
                    }
                },
                error: function (response){
                    // console.log(response);
                    console.log('error');
                }
            });

        });

        $('.btn_editStore').click(function () {
            var id = $(this).attr('value');
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
