<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=1,minimum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{{asset('vendors/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('vendors/jquery/wheel.js')}}"></script>
    <script  src="{{asset('vendors/jquery/rem.js')}}"></script>
    <title>{{$info['title']}}</title>
    <link rel="stylesheet" href="{{asset('vendors/css/wheel.css')}}" />
    <style>
        .lottery {
            position: relative;
            display: inline-block;
            width: 100%;
            height: 7.5rem;
        }
        .lottery canvas{
            
        }
        .lottery img {
            position: absolute;
            top: 50%;
            left: 50%;
            margin-left: -0.9rem;
            margin-top: -0.99rem;
            cursor: pointer;
        }
        #start{
            width: 1.8rem;
            height: 1.98rem;
        }
        #message {
            position: absolute;
            top: 0px;
            left: 10%;
        }
    </style>
</head>

<body>
    <audio loop  src = "{{asset('vendors/video/bg.mp3')}}"></audio>
    <div class="music-logo" id="music-logo"></div>
    <!--<div class=""--> 
    <div class="box">
        <a href="javascript:void(0)" class="b_b" onclick="s_h()"></a>
        <canvas id="myCanvas" width="600" height="600" style="margin-top: 1.98rem;">
            当前浏览器版本过低，请使用其他浏览器尝试
        </canvas>
        <img src="{{asset('vendors/images/2.png')}}" id="start" class='inner'>
        @if($info['info']['join_num_show'])
            <p style="margin-top: 1rem;">已有<span id="join_num">{{($joinNum+$info['info']['join_num_xuni'])}}</span>人参与</p>
        @endif
        <p>您今天还有<span id="todayCount">{{($info['info']['join_num_count_num_day']- $todayLeftOver)>0?$info['info']['join_num_count_num_day']- $todayLeftOver:0}}</span>次抽奖机会</p>
        @if(!$info['info']['join_num_count'])
            <p>已经使用<span id="useNum">{{$useNum}}</span>次抽奖机会</p>
            <p>总共有<span>{{$info['info']['join_num_count_num']}}</span>次抽奖机会</p>
        @endif
        <!--说明-->
        <div class="shuoming">
            <h2><a href="javascript:void(0)" onclick="close_h()">X</a></h2>
            <h3>
                <p class="s_1"><span class="span">活动说明</span></p>
                <p class="s_2"><span>我的奖品</span></p>
            </h3>
            <div class="tab1">
                <div class="b_t"><span>活动奖品</span></div>
                @if($info['info']['price_title'])
                    @for($i=0;$i<count($info['info']['price_title']);$i++)
                        <p>{{$info['info']['price_title'][$i]}}</p>        
                    @endfor
                @endif
                <div class="b_t"><span>活动时间</span></div>
                <p>{{ $info['info']['start_at'] }}-{{ $info['info']['end_at'] }}</p>
                <div class="b_t"><span>主办单位</span></div>
                <p>本次活动主办单位为~</p>
                <div class="b_t"><span>技术支持</span></div>
                <p>页面技术由<a href="" style="color: #ffe400;">翡翠科技（点击了解）</a>提供，技术支持方仅提供页面技术，不承担活动引起的相关法律责任</p>
                <div class="b_t"><span>活动说明</span></div>
                <p>{{$info['info']['desc']}}</p>
                <section class="c_j">
                    <a href="" >我要创建活动</a>
                </section>
            </div>
            <div class="tab2">
                <a href="">
                    @if(count($getOwnPrice))
                        @foreach($getOwnPrice as $k=>$v)
                            <div class="h_">
                                <p>{{$info['info']['price_title'][$v['is_luckly']-1]}}</p>
                                <p>兑奖日期：{{ $info['info']['price_start_at'] }} 至 {{ $info['info']['price_end_at'] }}</p>
                                <p><span>{{$v['is_sign']==1?'已核销':'未核销'}}</span></p>
                            </div>
                        @endforeach
                    @endif
                </a>
                <section class="a_n" style="margin-top: 1rem;">
                <a href="javascript:void(0)" >关注我们</a>
                </section>
                <section class="c_j">
                    <a href="javascript:void(0)" >我要创建活动</a>
                </section>
            </div>
        </div>
        <!--说明end-->
        <!--获奖-->
        <div class="huo">
            <img src="{{asset('vendors/images/4.png')}}" alt="" />
            <p class="text"></p>
            <!-- <p>价值</p>
            <section class="a_b">
                <a href="go.html" >价值一百礼品</a>
            </section> -->
            <section class="c_j">
                <a href="javascript:void(0)" >我要创建活动</a>
            </section>
        </div>
        
        <!--获奖end-->
        <!--为获奖-->
         <div class="no_huo">
            <p id="res">啊哦~没有中奖哦</p>
            <img src="{{asset('vendors/images/1.png')}}" alt="" />
            <section class="a_n">
                <a href="javascript:void(0)" onclick="h_hide()">再来一次</a>
            </section>
            <section class="a_n" style="margin-bottom: 1rem;">
                <a href="javascript:void(0)" >关注我们</a>
            </section>
            <section class="c_j">
                <a href="javascript:void(0)" >我要创建活动</a>
            </section>
        </div>
        <!--为获奖end-->
    </div>

    <script>
        $(".s_1").click(function(){
            var _this = $(this);
            _this.children().addClass("span");
            $(".s_2").children().removeClass("span");
            $(".tab1").show();$(".tab2").hide();
        })
        $(".s_2").click(function(){
            var _this = $(this);
            _this.children().addClass("span");
            $(".s_1").children().removeClass("span");
            $(".tab2").show();$(".tab1").hide();
        })
        $("#myCanvas").attr("width",document.body.clientWidth).attr("height",document.body.clientWidth);
        function h_hide(){
            $('.no_huo').hide();
        }
        function s_h(){
            $('.shuoming').show();
        }
        function close_h(){
            $('.shuoming').hide();
        }
        var audio1 = document.querySelector( "audio" );

        var musicLogo = document.querySelector( ".music-logo" );
    
        var isStart = true;
        audio1.play();
        musicLogo.onclick=function(){
            if ( isStart == true ) {
                audio1.pause();
                isStart = false;
            }else if(isStart != true){
                audio1.play();
                isStart = true;
            }
        }
        var wheelSurf
        // 初始化装盘数据 正常情况下应该由后台返回
        var initData = {
            "success": true,
            "list": [
                        {
                            "id": 0,
                            "name": "谢谢参与",
                            "image": "{{asset('vendors/images/98.png')}}",
                            "rank":0,
                        },
                        @if($info['info']['price_title'])
                            @for($i=0;$i<count($info['info']['price_title']);$i++)
                                {
                                    "id": {{ $i+1 }},
                                    "name": "{{$info['info']['price_title'][$i]}}",
                                    "image": "{{asset('vendors/images/99.png')}}",
                                    "rank": {{ $i+1 }},
                                },
                            @endfor
                        @endif
            ]
        }
        var list = {}
        var angel = 360 / initData.list.length
        // 格式化成插件需要的奖品列表格式
        for (var i = 0, l = initData.list.length; i < l; i++) {
            list[initData.list[i].rank] = {
                id:initData.list[i].id,
                name: initData.list[i].name,
                image: initData.list[i].image
            }
        }
        // 查看奖品列表格式
        // 定义转盘奖品
        wheelSurf = $('#myCanvas').WheelSurf({
            list: list, // 奖品 列表，(必填)
            outerCircle: {
                color: '#df1e15' // 外圈颜色(可选)
            },
            innerCircle: {
                color: '#ff732a' // 里圈颜色(可选)
            },
            dots: ['#ffefbe', '#ffffff'], // 装饰点颜色(可选)
//          disk: ['#f7d328', '#f7d328', '#f7d328', '#f7d328', '#f7d328', '#f7d328', '#f7d328'], //中心奖盘的颜色，默认7彩(可选)
            title: {
                color: '#e30002',
                font: '0.3rem Arial'
            } // 奖品标题样式(可选)
        })

        // 初始化转盘
        wheelSurf.init()
        // 抽奖
        var throttle = true;
        $("#start").on('click', function () {
            $.ajax({
                url: '{{ url("/luckly/ajaxLucklyButton") }}',
                type: 'post',
                dataType: 'json',
                data: {temp_id: {{ $info['id'] }},'_token':'{{ csrf_token() }}'},
            })
            .done(function(data) {
                var winData = data// 正常情况下获奖信息应该由后台返回
                $("#message").html('')
                if(!throttle){
                    return false;
                }
                throttle = false;
                var count = 0
                // 计算奖品角度
                for (const key in list) {
                    if (list.hasOwnProperty(key)) {                    
                        if (winData.luckly == list[key].id) {
                            break;
                        }
                        count++    
                    }
                }
                // 转盘抽奖，(count * angel + angel / 2)
                //angel 是奖品角度   顺时针从 0 开始  加720 旋转周圈 （一周圈为360）
                //angel = 旋转角度 + 720
                wheelSurf.lottery( 720+360-(count * angel + angel / 2),function () {
                    $('#join_num').html(Number($('#join_num').html())-1>0?Number($('#join_num').html())-1:0)
                    $('#todayCount').html(Number($('#todayCount').html())-1>0?Number($('#todayCount').html())-1:0)
                    $('#useNum').html(Number($('#useNum').html())+1)
                    if(winData.status){
                        $(".huo").show();
                        $(".text").html(winData.message);
                    }else{
                        $('#res').html(winData.message)
                        $(".no_huo").show();
                    }
                    throttle = true;
                })
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });  
        })  
    </script>
</body>

</html>