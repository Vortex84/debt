@if(count($sud)!=0)
    <div class="row rwttl"><div class="col-md-12 col-sm-12">Судебные</div></div>
    @foreach($sud as $val)
        <div class="row rwhov">
            <div class="col-md-8 col-sm-8">{{$val['title_bt']}}</div>
            <div class="col-md-4 col-sm-4"><button class="btn btn-xs blue" onclick="unload_blank({{$val['type']}});">Скачать</button>
            <button class="btn btn-xs red" onclick="del_blank({{$val['idblj']}},{{$val['type']}});">Удалить</button></div>
        </div>
    @endforeach
@endif
@if(count($sogl)!=0)
    <div class="row rwttl"><div class="col-md-12 col-sm-12">Соглашение</div></div>
    @foreach($sogl as $val)
        <div class="row rwhov">
            <div class="col-md-8 col-sm-8">{{$val['title_bt']}}</div>
            <div class="col-md-4 col-sm-4"><button class="btn btn-xs blue" onclick="unload_blank({{$val['type']}});">Скачать</button>
            <button class="btn btn-xs red" onclick="del_blank({{$val['idblj']}},{{$val['type']}});">Удалить</button></div>
        </div>
    @endforeach
@endif
@if(count($isp)!=0)
    <div class="row rwttl"><div class="col-md-12 col-sm-12">ССП</div></div>
    @foreach($sogl as $val)
        <div class="row rwhov">
            <div class="col-md-8 col-sm-8">{{$val['title_bt']}}</div>
            <div class="col-md-4 col-sm-4"><button class="btn btn-xs blue" onclick="unload_blank({{$val['type']}});">Скачать</button>
            <button class="btn btn-xs red" onclick="del_blank({{$val['idblj']}},{{$val['type']}});">Удалить</button></div>
        </div>
    @endforeach
@endif
@if(count($bank)!=0)
    <div class="row rwttl"><div class="col-md-12 col-sm-12">Банк</div></div>
    @foreach($sogl as $val)
        <div class="row rwhov">
            <div class="col-md-8 col-sm-8">{{$val['title_bt']}}</div>
            <div class="col-md-4 col-sm-4"><button class="btn btn-xs blue" onclick="unload_blank({{$val['type']}});">Скачать</button>
            <button class="btn btn-xs red" onclick="del_blank({{$val['idblj']}},{{$val['type']}});">Удалить</button></div>
        </div>
    @endforeach
@endif