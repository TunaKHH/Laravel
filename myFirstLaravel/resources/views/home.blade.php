@extends('layouts.app') @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <!-- <div class="card-header">主畫面</div> -->

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
                            <form>
                                <div class="row">
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="訂單名稱">
                                    </div>
                                    <div class="col">
                                        <select id="inputState" class="form-control">
                                            <option selected>請選擇店家</option>
                                            @foreach($stores as $store)
                                            <option>
                                                {{ $store->name }}
                                            </option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="col">
                                        <button type="submit" class="btn btn-primary">
                                            新增</button>
                                    </div>
                                </div>
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
                            </form>
                        </div>

                        <div class="tab-pane fade" id="pills-store" role="tabpanel" aria-labelledby="pills-store-tab">

                            <?php echo Form::open(array('action' => 'HomeController@setNewStore'))?>
                            <div class="row">
                                <div class="col">
                                    <input name="setStoreName" type="text" class="form-control" placeholder="店家名稱" required>
                                </div>
                                <div class="col">
                                    <input name="setStoretel" type="text" class="form-control" placeholder="店家電話" required>
                                </div>
                                <div class="col">
                                    <select name="setStoreType" id="setStoreType" class="form-control">
                                        <option selected>請選擇商店類型</option>
                                        <option value="0">飲料店</option>
                                        <option value="1">便當店</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-primary">新增</button>
                                </div>
                            </div>
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
                                                <button value="{{$store->id}}" type="button" class="btn btn-danger btn-sm">
                                                    <i class="far fa-trash-alt fa-xs"></i>
                                                </button>
                                            </td>
                                            <td>
                                                <button value="{{$store->id}}" type="button" class="btn btn-warning btn-sm" style="background-color: #ffc107;border-color: #ffc107;color: #ffffff;"
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
                            {{ Form::close() }}

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
                                        <input class="form-control form-control-lg" type="text" placeholder="請輸入訂單名稱">
                                    </div>
                                    <div class="form-group row">
                                        <select class="form-control form-control-lg">
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
        $('#btn_delOrder').click(function () {
            alert('hihi');
        });
    });
</script>
@endsection
