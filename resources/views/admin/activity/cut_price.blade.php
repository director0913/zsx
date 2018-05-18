<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title></title>
    <script src="{{asset('vendors/jquery/cut_price.js')}}" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/cut_price.css')}}"/>
</head>
<body>
	<form action="{{url('activity/store')}}" method="POST" enctype="multipart/form-data">
	<?php echo csrf_field(); ?>
	<input type="hidden" value="{{$id}}" name="cut_price_id">
	<input type="hidden" value="{{$id1}}" name="now_id">
	<div class="warp">
		<div class="head">
			<textarea type="text" placeholder="XX机构数招进行中，课程疯狂低价" value="XX机构数招进行中，课程疯狂低价" name="title"></textarea>
		</div>
		<p class="time">
			<span>活动时间：</span><input type="date" name="start_at"/>到<input type="date" name="end_at"/>
		</p>
		<div class="price">
			<p class='i_p i_p1'><span>原价：</span><input type="text" value="100" name="old_price" />元<span style="margin-left:1rem;">底价：</span><input type="text" value="20" name="bottom_price"/>元</p>
			<p class="text">每次减价减少范围</p>
			<p class='i_p'><span>减少：</span><input type="text" value="1" name="min_price" />元<span style="margin-left:1rem;">最多：</span><input type="text" value="11" name="max_price"/>元</p>
			<p class="text" style="text-align: center;">（原价-底价）÷大致帮减人数=帮减范围平均数，帮减范围平均数+5=最大值，帮减范围平均数-5=最小值。建议设置30-40人帮减即可减至最低价</p>
			<p class='i_p'><span>报名者每隔</span><input type="text" value="24" name="interval" />小时<span>可在此给自己减价</span></p>
			<p class="text" style="text-align: center;">每个报名可在活动时间内给自己多次减价，帮忙者仅有一次机会；如有用户报名，此时间可减不可增</p>
		</div>
		<div class="add_img">
			<p class="p"><span>本期奖品</span><input type="text" value="100" name="jiangpin_num" />份</p>
			<p class="p1">如有用户报名，奖品数量可增不可减，谨慎填写</p>
			<textarea class="text" name="jiangpin_info">少儿班6课时，一个月课程，新老学生均可参加此活动，原价300元 ，最低可减至2元。
			</textarea>
			<div class="add_">
				<div class="add_but">
					<input type="file" name="jiangpin_photo[]" style="opacity: 0; width: 100%; height: 100%;">
				</div>
				<p>(请上传5张奖品图片，不上传则不显示)</p>
			</div>
		</div>
		<div class="h_d">
			<div class="bj">
				<div class="bj_text">
					活动规则
				</div>
			</div>
			<textarea class="text" name="rule_info">少儿班6课时，一个月课程，新老学生均可参加此活动，原价300元 ，最低可减至2元。</textarea>
			<div class="h_but">
				<div class="b_1">添加文字</div>
				<div class="b_2">添加图片</div>
				<div class="b_3">添加视频</div>
			</div>
		</div>
		<div class="l_j">
			<div class="bj">
				<div class="bj_text">
					领奖信息 
				</div>
			</div>
			<textarea class="text" name="lingjiang_info">少儿班6课时，一个月课程，新老学生均可参加此活动，原价300元 ，最低可减至2元。</textarea>
			<div class="h_but">
				<div class="b_1">添加文字</div>
				<div class="b_2">添加图片</div>
				<div class="b_3">添加视频</div>
			</div>
		</div>
		<div class="l_j">
			<div class="bj">
				<div class="bj_text">
					机构介绍
				</div>
			</div>
			<textarea class="text" name="jigou_info">少儿班6课时，一个月课程，新老学生均可参加此活动，原价300元 ，最低可减至2元。</textarea>
			<div class="h_but">
				<div class="b_1">添加文字</div>
				<div class="b_2">添加图片</div>
				<div class="b_3">添加视频</div>
			</div>
		</div>
		<div class="add_user">
			<div class="bj">
				<div class="bj_text">
					信息收集
				</div>
			</div>
			<div class="user_1">
				<h3>门店</h3>
				<p class="p1"><input type="text" name="store_name" placeholder="请输入门店名称"/></p>
<!-- 				<p class="p2"><input type="text" placeholder="点击定位地址"/></p>
 -->				<p class="p3"><input type="text" name="store_addr" placeholder="请输入门店地址"/></p>
				<p class="p4"><input type="text" name="store_phone" placeholder="请输入联系电话"/></p>
				<a href="" class="bt"></a>
			</div>
			<!-- <div class="a_t">+点击添加门店</div> -->
		</div>
		<!-- 信息收集 -->
		<div class="add_info">
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
							<li><input type="text" name="name" placeholder="姓名"/></li>
							<li><input type="text" name="phone" placeholder="手机号码"/></li>
							<li><input type="text" name="xinxi1" placeholder="信息项名称"/></li>
							<li><input type="text" name="xinxi2" placeholder="信息项名称"/></li>
							<li><input type="text" name="xinxi3" placeholder="信息项名称"/></li>
						</ul>
					</div>
					<div class="list-right">
						
							<div class="checkbox-wrap">
									<p><input type="checkbox" value="guangpan" name="choose" id="guangpan">
									<label for="guangpan">必填项</label></p>
									<p><input type="checkbox" value="kaiche" name="choose" id="kaiche">
									<label for="kaiche">必填项</label></p>
									<p><input type="checkbox" value="laiji" name="choose" id="laiji">
									<label for="laiji">必填项</label></p>
									<p><input type="checkbox" value="baozhuang" name="choose" id="baozhuang">
									<label for="baozhuang">必填项</label></p>
									<p><input type="checkbox" value="bao" name="choose" id="bao">
									<label for="bao">必填项</label></p>
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
		<div class="footer">
			<ul>
				<li>预约活动</li>
				<li><input type="submit" value="保存活动"></li>
			</ul>
		</div>
	</div>
	</form>
</body>
</html>