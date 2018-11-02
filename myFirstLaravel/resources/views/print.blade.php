@extends('layouts.app') @section('content')
<div class="container" id="print_part">
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
            @php ($total_money = 0)
            @php ($total_q = 0)
            @foreach($datas as $data)
            @php ($total_money += $data->size =='S'?$data->price_s : $data->size =='M'?$data->price_m : $data->price_l)
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
            @php ($total_q += $data2->count)
            <tr>
                <th>{{$data2->menus_name}}</th>
                <td>{{$data2->size}}</td>
                <td>{{$data2->size =='S'?$data2->price_s : $data2->size =='M'?$data2->price_m : $data2->price_l }}</td>
                <td>{{$data2->count}}</td>
            </tr>
            @endforeach
            <tr>
                <td>總金額</td>
                <td>數量</td>
            </tr>
            <tr>
                <td>${{$total_money}}</td>
                <td>{{$total_q}}個</td>
            </tr>
        </tbody>
    </table>
</div>
<div style="text-align:center;">
    <button id="btn_print" type="button" class="btn btn-warning" style="background: #FF9800;border-color: #FF9800; color: white;" onclick="print_page()">列印</button>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">

    $(document).ready(function () {
        $('#btn_print').click(function(){
            var prtContent = document.getElementById("print_part");
            var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
            WinPrint.document.write(prtContent.innerHTML);
            WinPrint.document.close();
            WinPrint.focus();
            WinPrint.print();
            WinPrint.close();
        });
    });

</script>
@endsection