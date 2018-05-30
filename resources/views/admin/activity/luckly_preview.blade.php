<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title></title>
    <script src="{{asset('vendors/jquery/rem.js')}}"></script>
    <link rel="stylesheet" href="{{asset('vendors/css/luckly.css')}}" />
    <script src="{{asset('vendors/jquery/zepto.min.js')}}"></script>
    <script src="{{asset('vendors/jquery/kinerLottery.js')}}"></script>
</head>
<body>
    <audio loop autoplay="autoplay" src = "{{asset('vendors/video/bg.mp3')}}"></audio>
    <div class="music-logo" id="music-logo"></div>
    <div class="box" id="box">
        <a href="javascript:void(0)" class="b_b" onclick="s_h()"></a>
        <div class="outer KinerLottery KinerLotteryContent"><img src="{{asset('vendors/images/6.png')}}"></div>
        <!-- 大专盘分为三种状态：活动未开始（no-start）、活动进行中(start)、活动结束(completed),可通过切换class进行切换状态，js会根据这3个class进行匹配状态 -->
        <div class="inner KinerLotteryBtn start"></div>
        <p style="margin-top: 1rem;">已有<span>0</span>人参与</p>
        <p>您今天还有<span>3</span>次抽奖机会</p>
        <p>您总共有<span>3</span>次抽奖机会</p>
        <!--说明-->
        <div class="shuoming">
            <h2><a href="javascript:void(0)" onclick="close_h()">X</a></h2>
            <h3>
                <p><span class="span">活动说明</span></p>
                <p><span>我的奖品</span></p>
            </h3>
            <div class="b_t"><span>活动奖品</span></div>
            <p>一等奖：价值100元礼品</p>
            <p>二等奖：价值100元礼品</p>
            <p>三等奖：价值100元礼品</p>
            <p>三等奖：价值100元礼品</p>
            <p>三等奖：价值100元礼品</p>
            <p>三等奖：价值100元礼品</p>
            <div class="b_t"><span>活动时间</span></div>
            <p>2018年5月28日 12:30-2018年5月28日 12:30</p>
            <div class="b_t"><span>主办单位</span></div>
            <p>本次活动主办单位为~</p>
            <div class="b_t"><span>技术支持</span></div>
            <p>页面技术由<a href="" style="color: #ffe400;">翡翠科技（点击了解）</a>提供，技术支持方仅提供页面技术，不承担活动引起的相关法律责任</p>
            <div class="b_t"><span>活动说明</span></div>
            <section class="c_j">
                <a href="" >我要创建活动</a>
            </section>
        </div>
        <!--说明end-->
        <!--获奖-->
        <div class="huo">
            <img src="{{asset('vendors/images/4.png')}}" alt="" />
            <p class="text">一对对对</p>
            <p>价值</p>
            <section class="a_b">
                <a href="javascript:void(0)" >价值一百礼品</a>
            </section>
            <section class="c_j">
                <a href="javascript:void(0)" >我要创建活动</a>
            </section>
        </div>
        
        <!--获奖end-->
        <!--为获奖-->
         <div class="no_huo">
            <p>啊哦~没有中奖哦</p>
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
</body>
 <script>
        function h_hide(){
            $('.no_huo').hide();
        }
        function s_h(){
            $('.shuoming').show();
        }
        function close_h(){
            $('.shuoming').hide();
        }
        var audio = document.querySelector( "audio" );

        var musicLogo = document.querySelector( ".music-logo" );
    
        var isStart = true;
    
        musicLogo.onclick=function(){
            if ( isStart == false ) {
    
                musicLogo.classList.add( "playing" );
                audio.play();
                isStart = true;
            }else if(isStart != false){
                
                audio.pause();
                isStart = false;
                
            }
    
            
             
        }

        var whichAward = function(deg) {
            if ((deg > 330 && deg <= 360) || (deg > 0 && deg <= 30)) { //10M流量
                return "谢谢参与";
            } else if ((deg > 30 && deg <= 90)) { //IPhone 7
                return "一等奖";
            } else if (deg > 90 && deg <= 150) { //30M流量
                return "谢谢参与";
            } else if (deg > 150 && deg <= 210) { //5元话费
                return "二等奖";
            } else if (deg > 210 && deg <= 270) { //IPad mini 4
                return "谢谢参与";
            } else if (deg > 300 && deg <= 360) { //20元话费
                return "三等奖";
            }
        }
        var KinerLottery = new KinerLottery({
            rotateNum: 8, //转盘转动圈数
            body: "#box", //大转盘整体的选择符或zepto对象
            direction: 0, //0为顺时针转动,1为逆时针转动
            disabledHandler: function(key) {
                switch (key) {
                    case "noStart":
                        alert("活动尚未开始");
                        break;
                    case "completed":
                        alert("活动已结束");
                        break;
                }
            }, //禁止抽奖时回调
            clickCallback: function() {
                //此处访问接口获取奖品
                function random() {
                    return Math.floor(Math.random() * 360);
                }
                this.goKinerLottery(random());
            }, //点击抽奖按钮,再次回调中实现访问后台获取抽奖结果,拿到抽奖结果后显示抽奖画面
            KinerLotteryHandler: function(deg) {
                //console.log(deg)
                //console.log(whichAward(deg))
                    if(whichAward(deg) !="谢谢参与"){
                        $(".huo").show();
                        $(".text").html(whichAward(deg));
                    }else{
                        $(".no_huo").show();
                    }
                    

                } //抽奖结束回调
        });
    </script>
    <!-- 代码部分end -->
</html>