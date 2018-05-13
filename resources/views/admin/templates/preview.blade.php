
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
<style TYPE="text/css"> 
 #movie_box {
  width:100px;
  height:100px;
  background-color:blue;
  border-radius:50%;
  position:absolute;
}
</style> 
<body>
<!--    <div id="date" style="display:none">
        <input type="text" name="date" size="20" value＝""  class="easyui-datebox"/>
    </div> -->
    <form enctype="multipart/form-data" action="{{url('/admin/templates/store')}}" method="post">
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
    <input type="hidden" value="{{count($info['content_text'])}}" name="count">
    </span><span><input type="text" value="{{$info['title']}}" name="title"></span>
    <p>{!! $info['desc'] !!}</p>    
    </div>
    <div class=" all_660">  
        <div class="yd_box">
        @if($info['content_text'])
        @foreach($info['content_text'] as $k => $v)
            @if ($v['type']==1 || $v['type']==15)  
                <div id="wen{{$k}}" class="movie_box" style="border: 1px solid rgb(255, 255, 255); cursor: default; left: 622px; top: 99px;">
                    <input type="hidden" name="type{{$k}}" value="{{$v['type']}}">
                    <input type="hidden" name="node[]" value="{{$k}}">
                    <input type="hidden" value="{{$k}}" name="now_id">
                    <input name="top{{$k}}" class="top" type="hidden" value="{{$v['top']}}">
                    <input name="left{{$k}}" class="left" type="hidden" value="{{$v['left']}}">
                    <span>是否必填</span>
                    <input type="checkbox" value="1" name="is_required{{$k}}">
                    <ul class="wjdc_list"> 
                        <li>
                            <div class="tm_btitlt">
                                <i class="btwenzi">
                                    <input type="text" name="biaoti_title{{$k}}" value="{{$v['biaoti_title']}}">
                                </i>
                                <input>
                                <!-- <span class="tip_wz">【多选】</span> -->
                            </div>
                        </li>
                        @foreach($v['duoxuan_option'] as $k1 => $v1)
                        <li>
                            <label>
                                <input name="a"
                                @if($v['type']==1)
                                    type="checkbox"
                                @elseif($v['type']==15)
                                    type="radio"
                                @endif
                                value="">
                                <input type="hidden" value="{{$v1}}" name="duoxuan_option{{$k}}[]">
                                <span>{{$v1}}</span>
                            </label>
                        </li>
                        @endforeach
                    </ul>
                    <div class="dx_box" data-t="1" style="display: none;"></div>
                </div>
            @elseif($v['type']==2)
               <div id="wen{{$k}}" class="movie_box">
                    <input name="type{{$k}}" class="top" type="hidden" value="{{$v['type']}}">
                    <input type="hidden" name="node[]" value="{{$k}}">
                    <input name="top{{$k}}" class="top" type="hidden" value="{{$v['top']}}">
                    <input name="left{{$k}}" class="left" type="hidden" value="{{$v['left']}}">
                    <span>是否必填</span><input type="checkbox" value="1" @if($v['is_required']==1) checked="checked" @endif name="is_required{{$k}}" name="is_required{{$k}}">
                    <input type="text">
                    <ul class="wjdc_list">
                        <li>
                            <div class="tm_btitlt">
                                <i class="btwenzi">
                                    <h4>{{$v['biaoti_title']}}</h4><input><input class="biaoti_title" type="hidden" name="biaoti_title{{$k}}" value="{{$v['biaoti_title']}}">
                                </i>
                            </div>
                        </li>
                    </ul>
                    <div class="dx_box" data-t="{{$v['type']}}" style="display: none;"></div>
                </div>
            @elseif($v['type']==15)
                <div id="wen{{$k}}" class="movie_box">
                    <input name="type{{$k}}" class="top" type="hidden" value="{{$v['type']}}">
                    <input type="hidden" name="node[]" value="{{$k}}">
                    <input name="top{{$k}}" class="top" type="hidden" value="{{$v['top']}}">
                    <input name="left{{$k}}" class="left" type="hidden" value="{{$v['left']}}">
                    <span>是否必填</span><input type="checkbox" value="1" @if($v['is_required']==1) checked="checked" @endif name="is_required{{$k}}" name="is_required{{$k}}">
                    <input type="text">
                    <ul class="wjdc_list">
                        <li>
                            <div class="tm_btitlt">
                                <i class="btwenzi">
                                    <h4>{{$v['biaoti_title']}}</h4><input><input class="biaoti_title" type="hidden" name="biaoti_title{{$k}}" value="{{$v['biaoti_title']}}">
                                </i>
                            </div>
                        </li>
                    </ul>
                    <div class="dx_box" data-t="{{$v['type']}}" style="display: none;"></div>
                </div>
             @elseif($v['type']==6 || $v['type']==5)
                <div id="wen{{$k}}" class="movie_box">
                    <input name="type{{$k}}" type="hidden" value="{{$v['type']}}">
                    <input name="top{{$k}}" class="top" type="hidden" value="{{$v['top']}}">
                    <input name="left{{$k}}" class="left" type="hidden" value="{{$v['left']}}">
                    <span>是否必填</span><input type="checkbox" value="1" @if($v['is_required']==1) checked="checked" @endif name="is_required{{$k}}" name="is_required{{$k}}">
                    <ul class="wjdc_list">
                        <li>
                            <div class="tm_btitlt">
                                <i class="btwenzi">
                                    <h4>{{$v['biaoti_title']}}</h4><input type="file"><input class="biaoti_title" type="hidden" name="biaoti_title{{$k}}" value="{{$v['biaoti_title']}}">
                                </i>
                            </div>
                        </li>
                    </ul>
                    <div class="dx_box" data-t="{{$v['type']}}" style="display: none;"></div>
                </div>
            @elseif($v['type']==96)
                <div id="wen{{$k}}" class="movie_box">
                    <input name="type{{$k}}" class="top" type="hidden" value="{{$v['type']}}">
                    <input type="hidden" name="node[]" value="{{$k}}">
                    <input name="top{{$k}}" class="top" type="hidden" value="{{$v['top']}}">
                    <input name="left{{$k}}" class="left" type="hidden" value="{{$v['left']}}">
                    <span>是否必填</span><input type="checkbox" value="1" @if($v['is_required']==1) checked="checked" @endif name="is_required{{$k}}" name="is_required{{$k}}">
                    <input type="text">
                    <ul class="wjdc_list">
                        <li>
                            <div class="tm_btitlt">
                                <i class="btwenzi">
                                    <h4>{{$v['biaoti_title']}}</h4><input><input class="biaoti_title" type="hidden" name="biaoti_title{{$k}}" value="{{$v['biaoti_title']}}">
                                </i>
                            </div>
                        </li>
                    </ul>
                    <div class="dx_box" data-t="{{$v['type']}}" style="display: none;"></div>
                </div>
                  
            @elseif($v['type']==13)
                <div id="wen{{$k}}" class="movie_box">
                    <input name="type{{$k}}" class="top" type="hidden" value="{{$v['type']}}">
                    <input type="hidden" name="node[]" value="{{$k}}">
                    <input name="top{{$k}}" class="top" type="hidden" value="{{$v['top']}}">
                    <input name="left{{$k}}" class="left" type="hidden" value="{{$v['left']}}">
                    <span>是否必填</span><input type="checkbox" value="1" @if($v['is_required']==1) checked="checked" @endif name="is_required{{$k}}" name="is_required{{$k}}">
                    <input type="text">
                    <ul class="wjdc_list">
                        <li>
                            <div class="tm_btitlt">
                                <i class="btwenzi">
                                    <h4>{{$v['biaoti_title']}}</h4><input><input class="biaoti_title" type="hidden" name="biaoti_title{{$k}}" value="{{$v['biaoti_title']}}">
                                </i>
                            </div>
                        </li>
                    </ul>
                    <div class="dx_box" data-t="{{$v['type']}}" style="display: none;"></div>
                </div>
            @elseif($v['type']==7)
                <div id="wen{{$k}}" class="movie_box">
                    <input name="type{{$k}}" class="top" type="hidden" value="{{$v['type']}}">
                    <input type="hidden" name="node[]" value="{{$k}}">
                    <input name="top{{$k}}" class="top" type="hidden" value="{{$v['top']}}">
                    <input name="left{{$k}}" class="left" type="hidden" value="{{$v['left']}}">
                    <span>是否必填</span><input type="checkbox" value="1" @if($v['is_required']==1) checked="checked" @endif name="is_required{{$k}}" name="is_required{{$k}}">
                    <input type="text">
                    <ul class="wjdc_list">
                        <li>
                            <div class="tm_btitlt">
                                <i class="btwenzi">
                                    <h4>{{$v['biaoti_title']}}</h4><input><input class="biaoti_title" type="hidden" name="biaoti_title{{$k}}" value="{{$v['biaoti_title']}}">
                                </i>
                            </div>
                        </li>
                    </ul>
                    <div class="dx_box" data-t="{{$v['type']}}" style="display: none;"></div>
                </div>
                    
            @elseif($v['type']==9)
                <div id="wen{{$k}}" class="movie_box">
                    <input name="type{{$k}}" class="top" type="hidden" value="{{$v['type']}}">
                    <input type="hidden" name="node[]" value="{{$k}}">
                    <input name="top{{$k}}" class="top" type="hidden" value="{{$v['top']}}">
                    <input name="left{{$k}}" class="left" type="hidden" value="{{$v['left']}}">
                    <span>是否必填</span><input type="checkbox" value="1" @if($v['is_required']==1) checked="checked" @endif name="is_required{{$k}}" name="is_required{{$k}}">
                    <input type="text">
                    <ul class="wjdc_list">
                        <li>
                            <div class="tm_btitlt">
                                <i class="btwenzi">
                                    <h4>{{$v['biaoti_title']}}</h4><input><input class="biaoti_title" type="hidden" name="biaoti_title{{$k}}" value="{{$v['biaoti_title']}}">
                                </i>
                            </div>
                        </li>
                    </ul>
                    <div class="dx_box" data-t="{{$v['type']}}" style="display: none;"></div>
                </div>
                  
            @elseif($v['type']==8)
               <div id="wen{{$k}}" class="movie_box">
                    <input name="type{{$k}}" class="top" type="hidden" value="{{$v['type']}}">
                    <input type="hidden" name="node[]" value="{{$k}}">
                    <input name="top{{$k}}" class="top" type="hidden" value="{{$v['top']}}">
                    <input name="left{{$k}}" class="left" type="hidden" value="{{$v['left']}}">
                    <span>是否必填</span><input type="checkbox" value="1" @if($v['is_required']==1) checked="checked" @endif name="is_required{{$k}}" name="is_required{{$k}}">
                    <input type="text">
                    <ul class="wjdc_list">
                        <li>
                            <div class="tm_btitlt">
                                <i class="btwenzi">
                                    <h4>{{$v['biaoti_title']}}</h4><input><input class="biaoti_title" type="hidden" name="biaoti_title{{$k}}" value="{{$v['biaoti_title']}}">
                                </i>
                            </div>
                        </li>
                    </ul>
                    <div class="dx_box" data-t="{{$v['type']}}" style="display: none;"></div>
                </div>
                 
            @elseif($v['type']==10)
                <div id="wen{{$k}}" class="movie_box">
                    <input name="type{{$k}}" class="top" type="hidden" value="{{$v['type']}}">
                    <input type="hidden" name="node[]" value="{{$k}}">
                    <input name="top{{$k}}" class="top" type="hidden" value="{{$v['top']}}">
                    <input name="left{{$k}}" class="left" type="hidden" value="{{$v['left']}}">
                    <span>是否必填</span><input type="checkbox" value="1" @if($v['is_required']==1) checked="checked" @endif name="is_required{{$k}}" name="is_required{{$k}}">
                    <input type="text">
                    <ul class="wjdc_list">
                        <li>
                            <div class="tm_btitlt">
                                <i class="btwenzi">
                                    <h4>{{$v['biaoti_title']}}</h4><input><input class="biaoti_title" type="hidden" name="biaoti_title{{$k}}" value="{{$v['biaoti_title']}}">
                                </i>
                            </div>
                        </li>
                    </ul>
                    <div class="dx_box" data-t="{{$v['type']}}" style="display: none;"></div>
                </div>
                  
            @elseif($v['type']==11)
                <div id="wen{{$k}}" class="movie_box">
                    <input name="type{{$k}}" class="top" type="hidden" value="{{$v['type']}}">
                    <input type="hidden" name="node[]" value="{{$k}}">
                    <input name="top{{$k}}" class="top" type="hidden" value="{{$v['top']}}">
                    <input name="left{{$k}}" class="left" type="hidden" value="{{$v['left']}}">
                    <span>是否必填</span><input type="checkbox" value="1" @if($v['is_required']==1) checked="checked" @endif name="is_required{{$k}}" name="is_required{{$k}}">
                    <input type="text">
                    <ul class="wjdc_list">
                        <li>
                            <div class="tm_btitlt">
                                <i class="btwenzi">
                                    <h4>{{$v['biaoti_title']}}</h4><input><input class="biaoti_title" type="hidden" name="biaoti_title{{$k}}" value="{{$v['biaoti_title']}}">
                                </i>
                            </div>
                        </li>
                    </ul>
                    <div class="dx_box" data-t="{{$v['type']}}" style="display: none;"></div>
                </div>
                  
            @elseif($v['type']==12)
                <div id="wen{{$k}}" class="movie_box">
                    <input name="type{{$k}}" class="top" type="hidden" value="{{$v['type']}}">
                    <input type="hidden" name="node[]" value="{{$k}}">
                    <input name="top{{$k}}" class="top" type="hidden" value="{{$v['top']}}">
                    <input name="left{{$k}}" class="left" type="hidden" value="{{$v['left']}}">
                    <span>是否必填</span><input type="checkbox" value="1" @if($v['is_required']==1) checked="checked" @endif name="is_required{{$k}}" name="is_required{{$k}}">
                    <input type="text">
                    <ul class="wjdc_list">
                        <li>
                            <div class="tm_btitlt">
                                <i class="btwenzi">
                                    <h4>{{$v['biaoti_title']}}</h4><input><input class="biaoti_title" type="hidden" name="biaoti_title{{$k}}" value="{{$v['biaoti_title']}}">
                                </i>
                            </div>
                        </li>
                    </ul>
                    <div class="dx_box" data-t="{{$v['type']}}" style="display: none;"></div>
                </div>
            @endif
            <script type="text/javascript">
                $(document).ready(function(e) {
                     //js定位各种元素
                    $('#wen{{$k}}').css({"position":"absolute","top":{{$v['top']}},"left":{{$v['left']}} });
                    //初始化移动方法
                    init('wen{{$k}}')
                })
            </script>
        @endforeach
        @endif
        </div>
<div class="cont">{!! $info['base_img'] !!}</div>
    <!-- <div id="movie_box" ></div> -->      
    </div>
        <div class="but" style="padding-top: 20px">
            <select id="addquerstions" class="addquerstions" name="">
              <option value="-1">添加问题</option>
              @foreach($typeInfo as $k => $v)
                <option value="{{$v['id']}}">{{$v['name']}}</option>
                @endforeach
            </select>
            <input type="submit" value="完成编辑"></form>
        </div>
        <!--选项卡区域  模板区域-->
        <div class="xxk_box">
            <div class="xxk_conn hide">
                <!--单选-->
                <div class="xxk_xzqh_box dxuan ">
                    <textarea name="" cols="" rows="" class="input_wenbk btwen_text btwen_text_dx" placeholder="单选题目"></textarea>
                    <div class="title_itram">
                        <div class="kzjxx_iteam">
                            <input name="" type="radio" value="" class="dxk">
                            <input name="" type="text" class="input_wenbk" value="" placeholder="选项">
                            <label>
                                <input name="" type="checkbox" value="" class="fxk"> <span>可填空</span>
                            </label> <a href="javascript:void(0);" class="del_xm">删除</a>
                        </div>
                    </div>
                    <a href="javascript:void(0)" class="zjxx">增加选项</a>
                    <a class="zjxx">宽度：</a><input name="" type="text" value="" class="dxk">
                    <a class="zjxx">高度：</a><input name="" type="text" value="" class="dxk">
                    
                    <!--完成编辑-->
                    <div class="bjqxwc_box">
                        <a href="javascript:void(0);" class="qxbj_but">取消编辑</a>
                        <a href="javascript:void(0);" class="swcbj_but"> 完成编辑</a>
                    </div>
                </div>
                <!--多选-->
                <div class="xxk_xzqh_box duoxuan hide">
                    <textarea name="" cols="" rows="" class="input_wenbk btwen_text btwen_text_duox" placeholder="多选题目"></textarea>
                    <div class="title_itram">
                        <div class="kzjxx_iteam">
                            <input name="" type="checkbox" value="" class="dxk">
                            <input name="" type="text" class="input_wenbk" value="选项" placeholder="选项">
                            <label>
                                <input name="" type="checkbox" value="" class="fxk"> <span>可填空</span></label>
                            <a href="javascript:void(0);" class="del_xm">删除</a>
                        </div>
                    </div>
                    <a href="javascript:void(0)" class="zjxx">增加选项</a>
                    <!--完成编辑-->
                    <div class="bjqxwc_box">
                        <a href="javascript:void(0);" class="qxbj_but">取消编辑</a>
                        <a href="javascript:void(0);" class="swcbj_but"> 完成编辑</a>
                    </div>
                </div>
                <!-- 填空-->
                <div class="xxk_xzqh_box tktm hide" style="z-index:999">
                    <textarea name="" cols="" rows="" class="input_wenbk btwen_text btwen_text_tk" placeholder="答题区"></textarea>
                    <!--完成编辑-->
                    <div class="bjqxwc_box">
                        <a href="javascript:void(0);" class="qxbj_but">取消编辑</a>
                        <a href="javascript:void(0);" class="swcbj_but"> 完成编辑</a>
                    </div>
                </div>
                <!--矩阵-->
                <div class="xxk_xzqh_box  hide">
                    <div class="line_dl"></div>
                    <div class="jztm">
                        <textarea name="" cols="" rows="" class="input_wenbk btwen_text" placeholder="题目"></textarea>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tbody>
                                <tr valign="top">
                                    <td width="135">
                                        <h4 class="ritwenz_xx">左标题</h4>
                                        <textarea name="" cols="" rows="" class="leftbtwen_text" placeholder="例子：CCTV1，CCTV2，CCTV3"></textarea>
                                    </td>
                                    <td>
                                        <h4 class="ritwenz_xx  ">
                                                右侧选项文字 <input type="radio" name="xz" value="0"
                                                    checked="checked" class="xzqk">单选<input
                                                    type="radio" value="1" name="xz" class="xzqk">多选
                                            </h4>
                                        <div class="title_itram">
                                            <div class="kzjxx_iteam">
                                                <input name="" type="text" class="input_wenbk jzwent_input" value="选项" onblur="if(!this.value)this.value='选项'" onclick="if(this.value&amp;&amp;this.value=='选项' )  this.value=''">
                                                <label>
                                                    <input name="" type="checkbox" value="" class="fxk"> <span>可填空</span></label> <a href="javascript:void(0);" class="del_xm">删除</a>
                                            </div>
                                            <div class="kzjxx_iteam">
                                                <input name="" type="text" class="input_wenbk jzwent_input" value="选项" onblur="if(!this.value)this.value='选项'" onclick="if(this.value&amp;&amp;this.value=='选项' )  this.value=''">
                                                <label>
                                                    <input name="" type="checkbox" value="" class="fxk"> <span>可填空</span></label> <a href="javascript:void(0);" class="del_xm">删除</a>
                                            </div>
                                            <div class="kzjxx_iteam">
                                                <input name="" type="text" class="input_wenbk jzwent_input" value="选项" onblur="if(!this.value)this.value='选项'" onclick="if(this.value&amp;&amp;this.value=='选项' )  this.value=''">
                                                <label>
                                                    <input name="" type="checkbox" value="" class="fxk"> <span>可填空</span></label> <a href="javascript:void(0);" class="del_xm">删除</a>
                                            </div>
                                        </div> <a href="javascript:void(0)" class="zjxx" style="margin-left: 0;">增加选项</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!--完成编辑-->
                        <div class="bjqxwc_box">
                            <a href="javascript:void(0);" class="qxbj_but">取消编辑</a> <a href="javascript:void(0);" class="swcbj_but"> 完成编辑</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript" src="/vendors/jquery/jquery-1.7.1-wenjuan.js"></script>  
<script type="text/javascript" src="/vendors/jquery/wenjuan_add.js"></script>
<script type="text/javascript" src="/vendors/jquery/wenjuan.js"></script>
<script type="text/javascript" src="/vendors/jquery/jquery.easyui.min.js"></script>
<script type="text/javascript" src="/vendors/jquery/jquery.easyui.mobile.js"></script>
<script type="text/javascript">
    $(document).ready(function(e) {
        $("[name='base_img']").val($('.cont').html())
    })
</script>
</html>
