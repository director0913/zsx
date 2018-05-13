
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{$info['title']}}</title>
    <link type="text/css" rel="stylesheet" href="/vendors/css/wenjuan_ht.css">
    <link type="text/css" rel="stylesheet" href="/vendors/css/icon.css">
    <link type="text/css" rel="stylesheet" href="/vendors/css/easyui.css">
    <link type="text/css" rel="stylesheet" href="/vendors/css/demo.css">
  <script type="text/javascript" src="/vendors/jquery/jquery-2.1.1.js"></script>
</head>
<body>
    <form enctype="multipart/form-data" action="{{url('/form/answer')}}" method="post">
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
    <p>{{$info['title']}}</p> 
    <p>{!! $info['desc'] !!}</p>    
    </div>
    <div class=" all_660">
        <div class="yd_box">
        <div class="cont">{!! $info['base_img'] !!}</div>
        @if($info['content_text'])
        @foreach($info['content_text'] as $k => $v)
            @if ($v['type']==1 || $v['type']==15) 
                <div id="wen{{$k}}" class="movie_box" style="border: 1px solid rgb(255, 255, 255); cursor: default; left: 622px; top: 99px;">
                    <input type="hidden" name="type{{$k}}" value="{{$v['type']}}">
                    <input type="hidden" name="node[]" value="{{$k}}">
                    <input type="hidden" value="{{$k}}" name="now_id">
                    <input name="top{{$k}}" class="top" type="hidden" value="{{$v['top']}}">
                    <input name="left{{$k}}" class="left" type="hidden" value="{{$v['left']}}">
                    
                    <input type="checkbox" value="1" name="is_required{{$k}}">
                    <ul class="wjdc_list"> 
                        <li>
                            <div class="tm_btitlt">
                                <i class="btwenzi">
                                    {{$v['biaoti_title']}}
                                </i>
                            </div>
                        </li>
                        @foreach($v['duoxuan_option'] as $k1 => $v1)
                        <li>
                            <label>
                                <input value="{{intval($k1+1)}}" 
                                @if($v['type']==1)
                                    type="checkbox" name="node{{$k}}[]" 
                                @elseif($v['type']==15)
                                    type="radio" name="node{{$k}}" @if($v['is_required']==1) data-options="required:true"@endif 
                                @endif
                                value="">
                                <span>{{$v1}}</span>
                            </label>
                        </li>
                        @endforeach
                    </ul>
                    <div class="dx_box" data-t="1" style="display: none;"></div>
                </div>
            @elseif($v['type']==2)
                 <div id="wen{{$k}}" class="movie_box">
                    <input type="hidden" name="node[]" value="{{$k}}">
                    <input type="hidden" name="type{{$k}}" value="{{$v['type']}}">
                    <h4>{{$v['biaoti_title']}}</h4><input type="text" name="node{{$k}}" @if($v['is_required']==1) data-options="required:true"@endif>
                </div>                  
            @elseif($v['type']==15)
                 <div id="wen{{$k}}" class="movie_box">
                    <input type="hidden" name="node[]" value="{{$k}}">
                    <input type="hidden" name="type{{$k}}" value="{{$v['type']}}">
                    <h4>{{$v['biaoti_title']}}</h4><input type="text" name="node{{$k}}" @if($v['is_required']==1) data-options="required:true"@endif>
                </div>                  
            @elseif($v['type']==5)
                <div id="wen{{$k}}" class="movie_box">
                    <input name="type{{$k}}" type="hidden" value="{{$v['type']}}">
                    <input type="hidden" name="node[]" value="{{$k}}">
                    <input name="top{{$k}}" class="top" type="hidden" value="{{$v['top']}}">
                    <input name="left{{$k}}" class="left" type="hidden" value="{{$v['left']}}">
                    <h4>{{$v['biaoti_title']}}</h4><input type="file" name="node{{$k}}[]">
                </div>
            @elseif($v['type']==6)
                <div id="wen{{$k}}" class="movie_box">
                    <input name="type{{$k}}" type="hidden" value="{{$v['type']}}">
                    <input type="hidden" name="node[]" value="{{$k}}">
                    <input name="top{{$k}}" class="top" type="hidden" value="{{$v['top']}}">
                    <input name="left{{$k}}" class="left" type="hidden" value="{{$v['left']}}">
                    <h4>{{$v['biaoti_title']}}</h4><input type="file" name="node{{$k}}" @if($v['is_required']==1) data-options="required:true"@endif>
                </div>
            @elseif($v['type']==96)
                 <div id="wen{{$k}}" class="movie_box">
                    <input type="hidden" name="node[]" value="{{$k}}">
                    <input type="hidden" name="type{{$k}}" value="{{$v['type']}}">
                    <h4>{{$v['biaoti_title']}}</h4><input type="text" name="node{{$k}}" @if($v['is_required']==1) data-options="required:true"@endif max="100">
                </div>                  
                  
            @elseif($v['type']==13)
                 <div id="wen{{$k}}" class="movie_box">
                    <input type="hidden" name="node[]" value="{{$k}}">
                    <input type="hidden" name="type{{$k}}" value="{{$v['type']}}">
                    <h4>{{$v['biaoti_title']}}</h4><input type="text" name="node{{$k}}" @if($v['is_required']==1) data-options="required:true"@endif  max="30">
                </div>                  
            @elseif($v['type']==7)
                 <div id="wen{{$k}}" class="movie_box">
                    <input type="hidden" name="node[]" value="{{$k}}">
                    <input type="hidden" name="type{{$k}}" value="{{$v['type']}}">
                    <h4>{{$v['biaoti_title']}}</h4><input  name="node{{$k}}" @if($v['is_required']==1) data-options="required:true"@endif size="20" value＝""  class="easyui-datetimebox" data-options="required:true,showSeconds:false">
                </div>                  
                    
            @elseif($v['type']==9)
                 <div id="wen{{$k}}" class="movie_box">
                    <input type="hidden" name="node[]" value="{{$k}}">
                    <input type="hidden" name="type{{$k}}" value="{{$v['type']}}">
                    <h4>{{$v['biaoti_title']}}</h4><input type="text" name="node{{$k}}" @if($v['is_required']==1) data-options="required:true"@endif>
                </div>                  
                  
            @elseif($v['type']==8)
                <div id="wen{{$k}}" class="movie_box">
                    <input type="hidden" name="node[]" value="{{$k}}">
                    <input type="hidden" name="type{{$k}}" value="{{$v['type']}}">
                    <h4>{{$v['biaoti_title']}}</h4><input type="text" name="node{{$k}}" @if($v['is_required']==1) data-options="required:true"@endif>
                </div>                  
                 
            @elseif($v['type']==10)
                <div id="wen{{$k}}" class="movie_box">
                    <input type="hidden" name="node[]" value="{{$k}}">
                    <input type="hidden" name="type{{$k}}" value="{{$v['type']}}">
                    <h4>{{$v['biaoti_title']}}</h4><input type="text" name="node{{$k}}" @if($v['is_required']==1) data-options="required:true"@endif class="easyui-textbox" validType="mobile" >
                </div>                  
            @elseif($v['type']==11)
                 <div id="wen{{$k}}" class="movie_box">
                    <input type="hidden" name="node[]" value="{{$k}}">
                    <input type="hidden" name="type{{$k}}" value="{{$v['type']}}">
                    <h4>{{$v['biaoti_title']}}</h4><input type="text" name="node{{$k}}" @if($v['is_required']==1) data-options="required:true"@endif>
                </div>                  
                  
            @elseif($v['type']==12)
                 <div id="wen{{$k}}" class="movie_box">
                    <input type="hidden" name="node[]" value="{{$k}}">
                    <input type="hidden" name="type{{$k}}" value="{{$v['type']}}">
                    <h4>{{$v['biaoti_title']}}</h4><input type="text" name="node{{$k}}" @if($v['is_required']==1) data-options="required:true"@endif>
                </div>                  
                  
            @endif
            <script type="text/javascript">
                $(document).ready(function(e) {
                     //js定位各种元素
                    $('#wen{{$k}}').css({"position":"absolute","top":{{$v['top']}},"left":{{$v['left']}} });
                })
            </script>
        @endforeach
        @endif
        </div>
    </div>
    <input type="submit" value="回答完毕">
    </form>
</body>
<script type="text/javascript" src="/vendors/jquery/jquery.easyui.min.js"></script>
<script type="text/javascript" src="/vendors/jquery/jquery.easyui.mobile.js"></script>
<script type="text/javascript">
$.extend($.fn.validatebox.defaults.rules, {
 CHS: {
  validator: function (value, param) {
   return /^[\u0391-\uFFE5]+$/.test(value);
  },
  message: '请输入汉字'
 },
 ZIP: {
  validator: function (value, param) {
   return /^[1-9]\d{5}$/.test(value);
  },
  message: '邮政编码不存在'
 },
 QQ: {
  validator: function (value, param) {
   return /^[1-9]\d{4,10}$/.test(value);
  },
  message: 'QQ号码不正确'
 },
 mobile: {
  validator: function (value, param) {
   return /^((\(\d{2,3}\))|(\d{3}\-))?13\d{9}$/.test(value);
  },
  message: '手机号码不正确'
 },
 loginName: {
  validator: function (value, param) {
   return /^[\u0391-\uFFE5\w]+$/.test(value);
  },
  message: '登录名称只允许汉字、英文字母、数字及下划线。'
 },
 safepass: {
  validator: function (value, param) {
   return safePassword(value);
  },
  message: '密码由字母和数字组成，至少6位'
 },
 equalTo: {
  validator: function (value, param) {
   return value == $(param[0]).val();
  },
  message: '两次输入的字符不一至'
 },
 number: {
  validator: function (value, param) {
   return /^\d+$/.test(value);
  },
  message: '请输入数字'
 },
 idcard: {
  validator: function (value, param) {
   return idCard(value);
  },
  message:'请输入正确的身份证号码'
 }
});
$(function(){
 $('#uiform input').each(function () {
   if ($(this).attr('required') || $(this).attr('validType'))
    $(this).validatebox();
  })
 });
</script>
</html>
