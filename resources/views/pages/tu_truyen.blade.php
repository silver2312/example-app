@extends('layouts.app')
@section('title', 'Tủ truyện')
@section('content')
<?php
use App\Models\Truyen\TruyenSub;
use App\Models\Truyen\Truyen;
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            @if($cout_tutruyen > 0)
                @foreach($data_tutruyen as $key => $value)
                    <?php
                        $truyen_sub = TruyenSub::find($key);
                        $truyen = Truyen::find($key);
                    ?>
                    @if(isset($truyen) && isset($truyen_sub))
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 col-4">
                                        <img src="{{$truyen->img}}" alt="{{$truyen_sub->tieu_de}}" class="img_custom" onerror="this.src='https://i.imgur.com/hQRlkUR.png';" >
                                    </div>
                                    <div class="col-md-9 col-8">
                                        <div class="card-title" style="text-transform: capitalize;"><a href="{{ url('truyen/'.$truyen->nguon.'/'.$truyen->id) }}">{{ $truyen_sub->tieu_de }}</a></div>
                                        <button class="btn btn-danger">Xoá</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
</div>

@endsection
