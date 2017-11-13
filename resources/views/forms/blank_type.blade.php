<select name="sel_blank" class="form-control"><option value="0" selected="selected">Укажите документ</option>
    <optgroup label="Судебные">
        @if(count($b2)!=0)
            @foreach($b2 as $val)
                <option value="{{$val['idbt']}}">{{$val['title_bt']}}</option>
            @endforeach
        @endif
    </optgroup>
    <optgroup label="Соглашение">
        @if(count($b3)!=0)
            @foreach($b3 as $val)
                <option value="{{$val['idbt']}}">{{$val['title_bt']}}</option>
            @endforeach
        @endif
    </optgroup>
    <optgroup label="ССП">
        @if(count($b4)!=0)
            @foreach($b4 as $val)
                <option value="{{$val['idbt']}}">{{$val['title_bt']}}</option>
            @endforeach
        @endif</optgroup>
    <optgroup label="Банк">
        @if(count($b5)!=0)
            @foreach($b5 as $val)
                <option value="{{$val['idbt']}}">{{$val['title_bt']}}</option>
            @endforeach
        @endif
    </optgroup>
</select>