<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="_token" content="{{ csrf_token() }}"/>
    <title></title>
    <script src="{{asset('vendors/jquery/jquery-2.1.1.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{asset('vendors/jquery/cut_price.js')}}" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/cut_price_preview.css')}}"/>
</head>
<body>
	<div class="warp">
		<div class="head">
			{{isset($info['info']['title'])?$info['info']['title']:''}}
		</div>
		<p class="time">
			<span>活动时间：</span><input type="text" disabled="disabled" value="{{$info['info']['start_at']}}"/>到<input type="text" disabled="disabled"  value="{{$info['info']['end_at']}}" />
		</p>
		<div class="price">
			<p class='i_p i_p1'><span>原价：</span><input type="text" disabled="disabled"  value="{{$info['info']['old_price']}}" />元<span style="margin-left:1rem;">底价：</span><input  disabled="disabled"  type="text" value="{{$info['info']['bottom_price']}}" />元</p>
			<p class="text">每次减价减少范围</p>
			<p class='i_p'><span>减少：</span><input disabled="disabled"  type="text" value="{{$info['info']['interval']}}" />元<span style="margin-left:1rem;">最多：</span><input disabled="disabled"  type="text" value="{{$info['info']['max_price']}}" />元</p>
			<p class="text" style="text-align: center;">（原价-底价）÷大致帮减人数=帮减范围平均数，帮减范围平均数+5=最大值，帮减范围平均数-5=最小值。建议设置30-40人帮减即可减至最低价</p>
			<p class='i_p'><span>报名者每隔</span><input disabled="disabled"  type="text" value="{{$info['info']['interval']}}" />小时<span>可在此给自己减价</span></p>
			<p class="text" style="text-align: center;">每个报名可在活动时间内给自己多次减价，帮忙者仅有一次机会；如有用户报名，此时间可减不可增</p>
		</div>
		<div class="add_img">
			<p class="p"><span>本期奖品</span><input disabled="disabled"  type="text" value="{{$info['info']['jiangpin_num']}}"  />份</p>
			<p class="p1">如有用户报名，奖品数量可增不可减，谨慎填写</p>
			<p class="text">{{$info['info']['jiangpin_info']}}</p>
			<div class="add_">
				@if(isset($info['info']['jiangpin_photo']) && $info['info']['jiangpin_photo'])
					@foreach($info['info']['jiangpin_photo'] as $k=>$v)
						<img src="{{asset($v)}}"/>
					@endforeach
				@endif
			</div>
		</div>
		<div class="h_d">
			<div class="bj"></div>
			<p class="text">{{$info['info']['rule_info']}}</p>
			<div class="add_">
				<img src="{{asset('vendors/images/icon1.png')}}"/>
			</div>
		</div>
		<div class="l_j">
			<div class="bj"></div>
			<p class="text">{{$info['info']['lingjiang_info']}}</p>
			<div class="add_">
				<img src="{{asset('vendors/images/icon1.png')}}"/>
			</div>
		</div>
		<div class="j_g">
			<div class="bj"></div>
			<p class="text">{{$info['info']['jigou_info']}}</p>
			<div class="add_">
				
			</div>
		</div>
		<div class="add_user">
			<div class="bj"></div>
			<div class="user_1">
				<h3>门店</h3>
				<p class="p1"><input disabled="disabled" type="text" value="{{$info['info']['store_name']}}"/></p>
				<p class="p2"><input disabled="disabled" type="text" value="{{$info['info']['store_addr']}}"/></p>
<!-- 				<p class="p3"><input disabled="disabled" type="text" /></p>
 -->				<p class="p4"><input disabled="disabled" type="text" value="{{$info['info']['store_phone']}}"/></p>
			</div>
		</div>
		<!-- 信息收集 -->
		<div class="add_info" style="display: none;">
			<div class="bj">
				<div class="bj_text">
					信息收集
				</div>
			</div>
				<div class="info-title">
					<ul>
						<li>自定义项为空则不显示,最多可填6个字</li>
						<li>如果有用户报名，此内容不可在做任何的修改</li>
					</ul>
				</div>
			    <div class="info-list">
					<div class="list-left">
						<ul>
							<li><input type="text" placeholder="姓名"/></li>
							<li><input type="text" placeholder="手机号码"/></li>
							<li><input type="text" placeholder="信息项名称"/></li>
							<li><input type="text" placeholder="信息项名称"/></li>
							<li><input type="text" placeholder="信息项名称"/></li>
						</ul>
					</div>
					<div class="list-right">
						
							<div class="checkbox-wrap">
									<input type="checkbox" value="guangpan" name="choose" id="guangpan">
									<label for="guangpan">必填项</label>
									<input type="checkbox" value="kaiche" name="choose" id="kaiche">
									<label for="kaiche">必填项</label>
									<input type="checkbox" value="laiji" name="choose" id="laiji">
									<label for="laiji">必填项</label>
									<input type="checkbox" value="baozhuang" name="choose" id="baozhuang">
									<label for="baozhuang">必填项</label>
									<input type="checkbox" value="bao" name="choose" id="bao">
									<label for="bao">必填项</label>
							</div>
					
					</div>
				
			</div>
			
	       
		</div>
		<!-- 排行榜 -->
		<div class="add_info">
			<div class="bj">
				<div class="bj_text">
					排行榜
				</div>
			</div>
				<div class="ranking">
					<div class="rank-header">
						<ul>
							<li>排名</li>
							<li>姓名</li>
							<li>目前价格</li>
						</ul>
					</div>
					<div class="rank-list"></div>
				</div>
			
	       
		</div>
		<div class="footer" >
			<ul>
				<li id="cut_price">砍价</li>
				<li>我要参加</li>
			</ul>
		</div>
	</div>
<form action="{{url('/activity/collect')}}" method="post">
	<input type="hidden" value="{{$info['id']}}" name="temp_id">
	<?php echo csrf_field(); ?>
	<div class="list-left">
		<ul>
			<li><input type="text" name="name" placeholder="姓名"/></li>
			<li><input type="text" name="phone" placeholder="手机号码"/></li>
			<li><input type="text" name="xinxi1" placeholder="信息项名称"/></li>
			<li><input type="text" name="xinxi2" placeholder="信息项名称"/></li>
			<li><input type="text" name="xinxi3" placeholder="信息项名称"/></li>
		</ul>
	</div>
	<input type="submit" value="参加">
</form>
</body>
<script type="text/javascript">
	$('#cut_price').click(function(){
		$.ajax({
			url: "{{url('/activity/ajaxCut_priceButton')}}",
			type: 'POST',
			dataType: 'json',
			data: {collect_id:{{$collect_id}},temp_id:{{$info['id']}}},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			},
		})
		.done(function() {
			console.log("success");
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		
	})
</script>
</html>