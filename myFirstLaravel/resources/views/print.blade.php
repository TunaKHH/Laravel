@extends('layouts.app') @section('content')
<div class="container">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">品名</th>
                <th scope="col">SIZE</th>
                <th scope="col">價格</th>
                <th scope="col">買方</th>
                <th scope="col">備註</th>
            </tr>
            </thead>
            <tbody>
            @foreach($datas as $data)
            <tr>
                <th scope="row">{{$data->menu_name}}</th>
                <td>{{$data->size}}</td>
                <td>{{$data->size =='S'?$data->price_s : $data->size =='M'?$data->price_m : $data->price_l }}</td>
                <td>{{$data->name}}</td>
                <td>{{$data->memo}}</td>
            </tr>
            @endforeach
            <tr>
                <th>統計</th>
            </tr>
            @foreach($datas2 as $data2)
            <tr>
                <th>{{$data2->menus_name}}</th>
                <td>{{$data2->size}}</td>
                <td>{{$data2->size =='S'?$data2->price_s : $data2->size =='M'?$data2->price_m : $data2->price_l }}</td>
                <td>{{$data2->count}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {

    });

</script>
@endsection