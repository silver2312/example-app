@extends('layouts.app')
@section('title', 'Danh sách chủng tộc')
@section('content')
<?php
use App\Models\Game\NangLuongModel;
use App\Models\Game\TheChatModel;
?>
<div class="container mt-5">
    <div class="table-responsive">
        <table class="table table-flush table-dark" id="datatable-buttons">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tên</th>
                    <th scope="col">Năng lượng</th>
                    <th scope="col">Thể chất</th>
                    <th scope="col">max lực</th>
                    <th scope="col">max trí</th>
                    <th scope="col">max bền</th>
                    <th scope="col">max mẫn</th>
                    <th scope="col">max tu luyện</th>
                    <th scope="col">max thọ nguyên</th>
                </tr>
            </thead>
            <tbody>
                @foreach($chung_toc as $key_chungtoc => $value_chungtoc)
                    <tr>
                        <th scope="row">{{$key_chungtoc}}</th>
                        <td><a href="#!" data-placement="bottom" rel="tooltip" data-html="true" title='{!!$value_chungtoc->gioi_thieu!!}'>{{$value_chungtoc->ten}}</a></td>
                        <td>
                            <?php
                                if(isset($data_chungtoc[$value_chungtoc->id])){
                                    $id_nangluong = [];
                                    foreach($data_chungtoc[$value_chungtoc->id]['nang_luong'] as $key_nl_c => $value_nl_c){
                                        $id_nangluong[] = $value_nl_c;
                                    }
                                    $nang_luong_ct = NangLuongModel::whereIn('id', $id_nangluong)->get();
                                    foreach($nang_luong_ct as $key_nl_ct => $value_nl_ct){
                                        echo '<span class="btn btn-sm btn-success mt-1">'.$value_nl_ct->ten.'</span>';
                                    }
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                if(isset($data_chungtoc[$value_chungtoc->id])){
                                    $id_thechat = [];
                                    foreach($data_chungtoc[$value_chungtoc->id]['the_chat'] as $key_tc_c => $value_tc_c){
                                        $id_thechat[] = $value_tc_c;
                                    }
                                    $the_chat_ct = TheChatModel::whereIn('id', $id_thechat)->get();
                                    foreach($the_chat_ct as $key_tc_ct => $value_tc_ct){
                                        echo '<span class="btn btn-sm btn-success mt-1">'.$value_tc_ct->ten_the_chat.'</span>';
                                    }
                                }
                            ?>
                        </td>
                        <td>{{$value_chungtoc->max_luc}}</td>
                        <td>{{$value_chungtoc->max_tri}}</td>
                        <td>{{$value_chungtoc->max_ben}}</td>
                        <td>{{$value_chungtoc->max_man}}</td>
                        <td>{{$value_chungtoc->max_exp}}</td>
                        <td>{{$value_chungtoc->max_thonguyen}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
