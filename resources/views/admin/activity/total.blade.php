@extends('layouts.admin')
@section('css')
<link href="{{asset('vendors/dataTables/datatables.min.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2>统计详情</h2>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('admin/activity/lists')}}">微活动列表</a>
        </li>
    </ol>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
            <a class="close-link">
                <i class="fa fa-times"></i>
            </a>
          </div>
        </div>
        <div class="ibox-content">
          @include('flash::message')
          <div class="table-responsive">
	          <table class="table table-striped table-bordered table-hover dataTablesAjax" >
		          <thead>
			          <tr>
			            <th>序号</th>
			            <th>姓名</th>
			            <th>手机号</th>
			            <th>当前价格</th>
			            <th>状态</th>
			            <th>完成时间</th>
                  <th>核销</th>
                  <th>报名时间</th>
                  <th>操作</th>
			          </tr>
		          </thead>
		          <tbody>
                @foreach($info as $k => $v)
                <tr role="row" class="odd">
                  <td class="sorting_1">{{$v['id']}}</td>
                  <td>{{$v['info']['name']}}</td>
                  <td>{{$v['phone']}}</td>
                  <td>{{$v['now_price']}}</td>
                  <td>{{$v['isSign']==1?'已完成':'已完成'}}</td>
                  <td>{{$v['isSign']==1?'已核销':'未核销'}}</td>
                  <td>{{$v['created_at']}}</td>
                  <td>{!! $v['action'] !!}</td>
                </tr>
                @endforeach
		          </tbody>
	          </table>
          </div>
        </div>
      </div>
  	</div>
  </div>
</div>
@endsection
@section('js')
<script src="{{asset('vendors/dataTables/datatables.min.js')}}"></script>
<script src="{{asset('vendors/layer/layer.js')}}"></script>

<script type="text/javascript">
  $(document).on('click','.destroy_item',function() {
    var _item = $(this);
    layer.confirm('{{trans('admin/alert.deleteTitle')}}', {
      btn: ['{{trans('admin/action.actionButton.destroy')}}', '{{trans('admin/action.actionButton.no')}}'],
      icon: 5,
    },function(index){
      _item.children('form').submit();
      layer.close(index);
    });
  });
  $(document).on('click','.reset_password',function() {
    var item = $(this);
    layer.confirm('{{trans('admin/alert.reset_password').config('admin.global.reset')}}', {
      btn: ['{{trans('admin/action.actionButton.reset')}}','{{trans('admin/action.actionButton.no')}}'] //按钮
    }, function(){
      var _id = item.attr('data-id');
      $.ajax({
        url:'/admin/user/'+_id+'/reset',
        success:function (response) {
          layer.msg(response.msg);
          layer.close(index);
        }
      });
    });
  });
</script>
@endsection