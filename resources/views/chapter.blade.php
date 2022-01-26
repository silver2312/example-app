@extends('layouts.app')
@section('title', $header)
@section('content')

    <div class="container mt-5">
        <div class="row">
            <div class="card">
                <div class="card-header text-center border-0 pb-0">
                    <h3 class="card-title" style="text-transform: capitalize;">{{ $header }}</h3>
                    <div>
                        <a class="btn btn-sm btn-primary" href="{{ url('truyen/'.$truyen->nguon.'/'.$truyen->id.'/'.$min) }}"><i class="ni ni-bold-left"></i></a>
                        <a href="{{ url('truyen/'.$truyen->nguon.'/'.$truyen->id) }}" class="btn btn-sm btn-primary">Mục lục</a>
                        <a class="btn btn-sm btn-primary" href="{{ url('truyen/'.$truyen->nguon.'/'.$truyen->id.'/'.$max) }}"><i class="ni ni-bold-right"></i></a>
                    </div>
                </div>
                <div class="contaier p-2">
                    @if(isset($truyen->link))
                        <small>@Truyện được dịch tại dichtienghoa</small>
                        <br>
                        <br>
                    @endif
                    {!! $data_chapter[$position]['noi_dung_sub'] !!}
                </div>
                <div class="card-header text-center border-0 pt-0">
                    <div>
                        <a class="btn btn-sm btn-primary" href="{{ url('truyen/'.$truyen->nguon.'/'.$truyen->id.'/'.$min) }}"><i class="ni ni-bold-left"></i></a>
                        <a href="{{ url('truyen/'.$truyen->nguon.'/'.$truyen->id) }}" class="btn btn-sm btn-primary">Mục lục</a>
                        <a class="btn btn-sm btn-primary" href="{{ url('truyen/'.$truyen->nguon.'/'.$truyen->id.'/'.$max) }}"><i class="ni ni-bold-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav aria-label="Page navigation example" style="position: fixed;bottom: 0;right: 5px;opacity:0.8;">
        <ul class="pagination">
            <li class="page-item">
                <a class="page-link" href="{{ url('truyen/'.$truyen->nguon.'/'.$truyen->id.'/'.$min) }}" aria-label="Previous">
                    <i class="fa fa-angle-left"></i>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            <li class="page-item">
                <a class="page-link" href="{{ url('truyen/'.$truyen->nguon.'/'.$truyen->id.'/'.$max) }}" aria-label="Next">
                    <i class="fa fa-angle-right"></i>
                    <span class="sr-only">Next</span>
                </a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                    <i class="ni ni-settings"></i>
                    <span class="sr-only">Setting</span>
                </a>
            </li>
        </ul>
    </nav>
    @section('script_ll')
        <script>
            function leftArrowPressed() {
                window.location.replace("{{ url('truyen/'.$truyen->nguon.'/'.$truyen->id.'/'.$min) }}");
            }

            function rightArrowPressed() {
                window.location.replace("{{ url('truyen/'.$truyen->nguon.'/'.$truyen->id.'/'.$max) }}");
            }

            document.onkeydown = function(evt) {
                evt = evt || window.event;
                switch (evt.keyCode) {
                    case 37:
                        leftArrowPressed();
                        break;
                    case 39:
                        rightArrowPressed();
                        break;
                }
            };
        </script>
    @endsection
@endsection
