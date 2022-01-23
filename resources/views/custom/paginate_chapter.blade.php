<div class="card">
    <div class="card-header font-weight-bold">Danh sách chương @if(isset($truyen->link))<a class="float-right" href="{{ url('truyen/'.$truyen->nguon.'/'.$truyen->id.'/dsc') }}"><i class='fas fa-redo'></i></a>@endif</div>
    <div class="card-body">
        <div class="row">
            @if(isset($data_chapter))
                @foreach ($data_chapter as $key => $chapter)
                    <div class="col-md-4">
                        <div class="card-header" style="padding:3px;">
                            <a href="{{ url('truyen/'.$truyen->nguon.'/'.$truyen->id.'/'.$key) }}" style="text-transform: capitalize;font-size:13px;" class="wrd p-1">Chương {{$key}}: {{$chapter['header_sub']}}</a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@if(isset($data_chapter))
{!! $data_chapter->onEachSide(0)->links('vendor.pagination.simple-default') !!}
@endif
<script>
    //dark mode
        var card_body = $('.card-body');
        var card_header = $('.card-header');
        var card = $('.card');
        $(document).ready(function(){
            if(localStorage.getItem('switch_color')!==null){
                const data = localStorage.getItem('switch_color');
                const data_obj = JSON.parse(data);
                card.addClass(data_obj.class_1);
                card_body.addClass(data_obj.class_1);
                card_header.addClass(data_obj.class_1);
            }
        });
    //end dark mode
</script>

