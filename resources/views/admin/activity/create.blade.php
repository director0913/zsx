<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>zhaosx</title>
    <script type="text/javascript" src="{{asset('vendors/jquery/jquery-2.1.1.js')}}"></script>

</head>
<body>
    <div id="date" style="display:none">
        <input type="text" name="date" size="20" value＝""  class="easyui-datebox"/>
    </div>
    <form enctype="multipart/form-data" action="{{url('/admin/templates/store')}}" method="post">
    <div class="but" style="padding-top: 20px">
            @if($cut_price_lists)
                @foreach($cut_price_lists as $k => $v)
                   {{$v['title']}} {!! QrCode::size(200)->generate(url('/activity/create/'.$v['id'].'/now/'.getUerId())) !!} 
                    {{url('/activity/create/'.$v['id'].'/now/'.getUerId())}}
                @endforeach
            @endif
    <div >  

    
</div> 
    </div>
   
</html>
