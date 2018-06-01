@extends('layouts.admin')
@section('css')
<link href="{{asset('vendors/dataTables/datatables.min.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2>微活动列表</h2>
  </div>
  @permission(config('admin.permissions.activity.create'))
  <div class="col-lg-2">
    <div class="title-action">
      <a href="{{url('admin/activity/create')}}" class="btn btn-info">创建活动</a>
    </div>
  </div>
  @endpermission
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">

          活动总数：{{$responseData['tempCount']}}    总浏览量：{{$responseData['views']}}      报名总数：{{$responseData['collectCount']}}
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
			            <th>编号</th>
			            <th>活动类型</th>
			            <th>活动标题</th>
			            <th>活动时间</th>
			            <th>活动状态</th>
			            <th>数据统计</th>
                  <th>创建时间</th>
                  <th>操作</th>
			          </tr>
		          </thead>
		          <tbody>
                @foreach($responseData['data'] as $k => $v)
                <tr role="row" class="odd">
                  <td class="sorting_1">{{$v['id']}}</td>
                  <td>{{$v['typename']}}</td>
                  <td>{{$v['title']}}</td>
                  <td>{{$v['info']['start_at']}}--{{$v['info']['end_at']}}</td>
                  <td>{{$v['status']}}</td>
                  <td><a href="{{url('/admin/activity/total/'.$v['id'])}}">统计详情</a></td>
                  <td>{!! $v['created_at'] !!}</td>
                  <td>{!! $v['action'] !!}</td>
                  <td>{!! QrCode::size(100)->generate(url('/activity/show/'.$v['id'])) !!} </td>
                </tr>
                @endforeach
		          </tbody>
	          </table>
          </div>
        </div>
        <div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate">
          <ul class="pagination">
            @if($responseData['length']>1)
              <li class="paginate_button first" id="DataTables_Table_0_first"><a href="{{url('/admin/activity/lists/1')}}" aria-controls="DataTables_Table_0" data-dt-idx="0" tabindex="0">首页</a></li>
              <li class="paginate_button previous" id="DataTables_Table_0_previous"><a href="{{url('/admin/activity/lists/'.($p-1==0?1:$p-1))}}" aria-controls="DataTables_Table_0" data-dt-idx="1" tabindex="0">上页</a></li>
              @for($i=1;$i-1<$responseData['length'];$i++)
                <li class="paginate_button @if($p==$i) active @endif"><a href="{{url('/admin/activity/lists/'.$i)}}" aria-controls="DataTables_Table_0" data-dt-idx="2" tabindex="0">{{$i}}</a></li>
              @endfor
              <li class="paginate_button next" id="DataTables_Table_0_next"><a href="{{url('/admin/activity/lists/'.($p+1<=$responseData['length']?$p+1:$responseData['length']))}}" aria-controls="DataTables_Table_0" data-dt-idx="7" tabindex="0">下页</a></li><li class="paginate_button last" id="DataTables_Table_0_last"><a href="{{url('/admin/activity/lists/'.$responseData['length'])}}" aria-controls="DataTables_Table_0" data-dt-idx="8" tabindex="0">末页</a></li>
            @endif
          </ul>
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
  //获取二维码
  $('.tooltips').mouseover(function(){
   
  })
  $('.tooltips').mouseout(function(){
    
  })
    
</script>
@endsection