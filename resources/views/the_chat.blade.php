@extends('layouts.app')
@section('title', 'Danh sách thể chất')
@section('content')
<?php
    use App\Models\Game\HeModel;
?>
<div class="container mt-5">
    <div class="table-responsive">
        <table class="table table-flush table-dark" id="datatable-buttons">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tên</th>
                    <th scope="col">Tỷ lệ</th>
                    <th scope="col">Hệ</th>
                    <th scope="col">Thêm lực</th>
                    <th scope="col">Thêm bền</th>
                    <th scope="col">Thêm trí</th>
                    <th scope="col">Thêm mẫn</th>
                    <th scope="col">Thêm buff hút exp</th>
                </tr>
            </thead>
            <tbody>
                @foreach($the_chat as $key_thechat => $value_thechat)
                    <tr>
                        <th scope="row">{{$key_thechat}}</th>
                        <td>{{$value_thechat->ten_the_chat}}</td>
                        <td>{{$value_thechat->ty_le*100}}%</td>
                        <td><?php $tenhe = HeModel::find($value_thechat->he_id); echo $tenhe->ten_he; ?></td>
                        <td>{{$value_thechat->buff_luc}}</td>
                        <td>{{$value_thechat->buff_ben}}</td>
                        <td>{{$value_thechat->buff_tri}}</td>
                        <td>{{$value_thechat->buff_man}}</td>
                        <td>{{$value_thechat->buff_exp}}</td>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
