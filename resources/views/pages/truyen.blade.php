@extends('layouts.app')
@section('title', 'Truyện của tôi')
@section('content')
<style>
    .table td, .table th{
        white-space:inherit;
    }
</style>
<div class="container mt-5">
    <h2 class="text-center">Bạn đang có : {{$count}} truyện</h2>
    {{ $truyen->links('vendor.pagination.simple-default') }}
    <div class="table-responsive">
        <table class="table table-flush table-dark">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th>Thông tin</th>
                    <th>Ảnh truyện</th>
                    <th>Nguồn</th>
                    <th>Thời gian</th>
                    <th>Thêm</th>
                    <th>Tên</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($truyen as $key =>$value)
                    <tr>
                        <th scope="row">{{ $key++ }}</th>
                        <td><a href="#!"></a>Thông tin</td>
                        <td><a href="{{ url('truyen/'.$value->nguon.'/'.$value->id) }}"><img src="{{$value->img}}" id="phongto" style="max-height:70px;" onerror="this.src='https://i.imgur.com/hQRlkUR.png';" ></a></td>
                        <td>{{$value->nguon}}</td>
                        <td>{{$value->time_suf}} - {{$value->time_up}}</td>
                        <td><a href="#!">Thêm</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $truyen->links('vendor.pagination.simple-default') }}
</div>

@endsection
