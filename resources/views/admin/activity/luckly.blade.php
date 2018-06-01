<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title></title>
    <script src="{{asset('vendors/jquery/jquery.min.js')}}"></script>
    <script  src="{{asset('vendors/jquery/rem.js')}}"></script>
    <link rel="stylesheet" href="{{asset('vendors/css/b.css')}}" />
</head>
<body>
    <div class="warp">
        <form action="{{ url('/luckly/'.$id) }}" method="post">
            {!!csrf_field()!!}
            {{method_field('POST')}}
            <input type="hidden" name="cut_price_id" value="{{$id}}">
            <input type="hidden" name="now_id" value="{{$id1}}">
            <!--基础设置-->
            <h3 class="b_t">基础设置</h3>
            <p class="p_title"><span>*</span>活动标题：<input class="t_1" type="text" name="title" value="参与活动赢大奖" /></p>
            <p class="p_title"><span>*</span>活动说明：<textarea class="t_1" type="text" name="desc">点击“开始”转盘开始转动，最终指针指着的即为您所中的奖品。</textarea></p>
            <p class="p_title"><span>*</span>活动时间：<input class="t_2" type="date" name="start_at"  value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}"/>至<input class="t_2" type="date" name="end_at" value="{{ date("Y-m-d",strtotime("+1 week")) }}" /></p>
            <p class="p_title"><span>&nbsp;</span>参与人数：&nbsp;&nbsp;<input class="" checked="checked" type="radio" name="join_num_show" value="0" />&nbsp;隐藏&nbsp;&nbsp;<input class="" type="radio" name="join_num_show" value="1" />&nbsp;显示</p>
            <p class="p_title"><span>&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;虚拟增加参与人数<input type="text" class="t_3" name="join_num_xuni" />人（只展示不计入统计）</p>
            <p class="p_title"><span>&nbsp;</span>参与人数限制：&nbsp;&nbsp;<input class="" checked="checked" value="0" type="radio" name="join_num_limit" />&nbsp;不限&nbsp;&nbsp;<input class="" type="radio" name="join_num_limit" value="1" />&nbsp;限制&nbsp;&nbsp;<input type="text" class="t_3" name="join_num" />人参与</p>
           <!--  <p class="p_title"><span>&nbsp;</span>强制关注：&nbsp;&nbsp;<input class="" type="radio" name="r" />&nbsp;开启&nbsp;&nbsp;<input class="" type="radio" name="r" />&nbsp;关闭&nbsp;&nbsp;</p> -->
            <!--派奖方式-->
            <h3 class="b_t">派奖方式</h3>
            <p class="p_title"><span>&nbsp;</span>总抽奖机会：&nbsp;&nbsp;<input class="" checked="checked" type="radio" name="join_num_count" value="1" />&nbsp;不限&nbsp;&nbsp;<input class="" type="radio" name="join_num_count" value="0" />&nbsp;限制&nbsp;&nbsp;总共<input type="text" class="t_3" name="join_num_count_num" />次抽奖机会</p>&nbsp;&nbsp;
            <p class="p_title"><span>&nbsp;</span>每日抽奖机会：每人每日有<input type="text" class="t_3" name="join_num_count_num_day" value="3" />次抽奖机会</p>
            <p class="p_title"><span>&nbsp;</span>每人中奖次数：每人最多可中奖<input type="text" class="t_3" name="winner_num" value="1" />次</p>
            <p class="p_title"><span>&nbsp;</span>总中奖率：<input type="text" class="t_3" name="winner_percent" value="10" />%</p>
            <!--奖项设置-->
            <h3 class="b_t">奖项设置</h3>
            <div class="list">
                 <p class="p_title"><span>*</span>奖品名称：<input class="t_1" type="text" name="price_title[]" value="一等奖" /></p>
                <p class="p_title"><span>*</span>奖品数量：<input class="t_1" type="text" name="price_num[]" value="1" /></p>
                <p class="p_title"><span>*</span>奖品名称：<input class="t_1" type="text" name="price_title[]" value="二等奖" /></p>
                <p class="p_title"><span>*</span>奖品数量：<input class="t_1" type="text" name="price_num[]" value="2" /></p>
            </div>
            <div class='add'>
                <p class="p_title"><span>*</span>奖品名称：<input class="t_1 j_1" type="text" /></p>
                <p class="p_title"><span>*</span>奖品数量：<input class="t_1 j_2" type="text" /></p>
                <input type="button" class="aptend" value="添加奖项" />
                <!-- <p class="p_title"><span>*</span>兑奖方式：&nbsp;&nbsp;<input class="" type="radio" name="r" />&nbsp;线下兑奖&nbsp;&nbsp;<input class="" type="radio" name="r" />&nbsp;公众号兑奖&nbsp;&nbsp;<input class="" type="radio" name="r" />&nbsp;网页兑奖</p> -->
                <p class="p_title"><span>*</span>奖品有效期：<input class="t_2" type="date" name="price_start_at" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}"/>至<input class="t_2" type="date" name="price_end_at" value="{{ date("Y-m-d",strtotime("+1 week")) }}" min="{{ date('Y-m-d') }}"/></p>
                <p class="p_title"><span>*</span>客服电话：<input class="t_1" type="text" name="price_phone" /></p>
                <p class="p_title"><span>*</span>兑奖须知：<input class="t_1" type="text" name="price_notice" /></p>
            </div>
            <input type="submit" value="保存" onclick="return check()" class="save"/>
        </form>
    </div>
    
</body>
<script>
    $(function(){
        
        $('.aptend').on("click",function(){
            //创建奖项
            var length = $(".list").children().length;
            if(length <= 7){
                var str = '<div class="b_r">'+
                                '<p style="text-align: right;"><a href="javascript:void(0)" onclick="remove(this)" class="remove">删除</a></p>'+
                                '<p class="p_title"><span>*</span>奖品名称：<input name="price_title[]" class="t_1" type="text" value="'+$(".j_1").val()+'"/></p>'+
                                '<p class="p_title"><span>*</span>奖品数量：<input name="price_num[]" class="t_1" type="text" value="'+$(".j_2").val()+'"/></p>'+
                            '</div>'
                $(".list").append(str)  ;
                //清空input的val 
                $(".j_1").val("");
                $(".j_2").val("");
            }else{
                alert("最多添加7个奖项");
            }
        })
    })
    //删除奖项
    function remove(obj){
        var _this = $(obj);
        _this.parent().parent().remove();
    }
    function check(){
        var title = $('[name="title"]').val();
        var start_at = $('[name="start_at"]').val();
        var end_at = $('[name="end_at"]').val();
        if (!title) {
            alert("请填写活动标题！")
            return false;
        }
        if (!start_at) {
            alert("活动开始时间必须选择！")
            return false;
        }
        if (!end_at) {
            alert("活动结束时间必须选择！")
            return false;
        }
    }
</script>
</html>