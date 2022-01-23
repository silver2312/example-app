@extends('layouts.app')
@section('title', $data_chapter[$position]['header_sub'])
@section('content')

<div class="container mt-5">
    <div class="row">
        <div class="card">
            <div class="contaier p-3">
                {!! $data_chapter[$position]['noi_dung_sub'] !!}
            </div>
        </div>
    </div>
</div>

@endsection
