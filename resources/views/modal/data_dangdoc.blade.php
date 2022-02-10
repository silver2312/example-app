<?php
    use App\Models\Truyen\TruyenSub;
    use App\Models\Truyen\Truyen;
?>
<?php
$data_dangdoc = data_dangdoc(Auth::user()->id);
try{
    $count_dd = count($data_dangdoc);
}catch(Throwable $e){
    $count_dd = 0;
}
?>
@if($count_dd > 0)
    <div class="table-responsive">
        <table class="table table-flush table-dark">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Truyện</th>
                    <th scope="col">Cài đặt</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data_dangdoc as $key => $value)
                    <?php
                        $truyen = Truyen::find($key);
                        $sub = TruyenSub::find($key);
                        try{
                            $tieu_de = $sub->tieu_de;
                        }catch(Throwable $e){
                            $tieu_de = $truyen->tieu_de;
                        }
                    ?>
                    @if(isset($truyen))
                        <tr>
                            <td>
                                <a href="{{ url('truyen/'.$truyen->nguon.'/'.$key) }}" style="color:white;">{{$tieu_de}}</a><br>
                                <?php
                                    $data_chapter = data_chapter($key);
                                ?>
                                @if(isset($data_chapter[$value['chapter']]) || isset($data_chapter[$value['chapter']]['header_sub']))
                                    <small><a style="color:red;" href="{{ url('truyen/'.$truyen->nguon.'/'.$key.'/'.$value['chapter']) }}">{{ $data_chapter[$value['chapter']]['header_sub'] }}</a></small>
                                @endif
                            </td>
                            <td><a href="#!" onclick="del_dangdoc_{{$key}}()" class="btn btn-sm btn-danger">X</a></td>
                            <script>
                                function del_dangdoc_{{$key}}(){
                                    var http = new XMLHttpRequest();
                                    var url = '{{url("truyen/del-dang-doc/".$key)}}';
                                    http.open('GET', url, true);
                                    http.send();
                                    data_dd();
                                }
                            </script>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@endif
