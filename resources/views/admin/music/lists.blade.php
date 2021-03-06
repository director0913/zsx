@extends('layouts.admin')
@section('css')
<link href="{{asset('vendors/dataTables/datatables.min.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2>背景音乐列表</h2>
  </div>
    @permission(config('admin.permissions.music.create'))
  <div class="col-lg-2">
    <div class="title-action">
      <a href="{{url('admin/music/create')}}" class="btn btn-info">添加音乐</a>
    </div>
  </div>
  @endpermission
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">

        <div class="ibox-content">
          @include('flash::message')
          <div class="table-responsive">
	          <table class="table table-striped table-bordered table-hover dataTablesAjax" >
		          <thead>
			          <tr>
			            <th>ID</th>
			            <th>音乐名称</th>
			            <th>简介</th>
                  <th>添加时间</th>
                  <th>修改时间</th>
			            <th>操作</th>
			          </tr>
		          </thead>
		          <tbody>
                @if($responseData['data'])
                  @foreach($responseData['data'] as $k => $v)
                  <tr role="row" class="odd">
                    <td class="sorting_1">{{$v['id']}}</td>
                    <td>{{$v['name']}}</td>
                    <td>{{$v['desc']}}</td>
                    <td>{{$v['created_at']}}</td>
                    <td>{{$v['updated_at']?$v['updated_at']:$v['created_at']}}</td>
                    <td>{!! $v['action'] !!}</td>
                  </tr>
                  @endforeach
                @endif
		          </tbody>
	          </table>
          </div>
        </div>
      </div>
      <div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate">
        <ul class="pagination">
          @if($responseData['length']>1)
            <li class="paginate_button first" id="DataTables_Table_0_first"><a href="{{url('/admin/music/lists/1')}}" aria-controls="DataTables_Table_0" data-dt-idx="0" tabindex="0">首页</a></li>
            <li class="paginate_button previous" id="DataTables_Table_0_previous"><a href="{{url('/admin/music/lists/'.($p-1==0?1:$p-1))}}" aria-controls="DataTables_Table_0" data-dt-idx="1" tabindex="0">上页</a></li>
            @for($i=1;$i-1<$responseData['length'];$i++)
              <li class="paginate_button @if($p==$i) active @endif"><a href="{{url('/admin/music/lists/'.$i)}}" aria-controls="DataTables_Table_0" data-dt-idx="2" tabindex="0">{{$i}}</a></li>
            @endfor
            <li class="paginate_button next" id="DataTables_Table_0_next"><a href="{{url('/admin/music/lists/'.($p+1<=$responseData['length']?$p+1:$responseData['length']))}}" aria-controls="DataTables_Table_0" data-dt-idx="7" tabindex="0">下页</a></li><li class="paginate_button last" id="DataTables_Table_0_last"><a href="{{url('/admin/music/lists/'.$responseData['length'])}}" aria-controls="DataTables_Table_0" data-dt-idx="8" tabindex="0">末页</a></li>
          @endif
        </ul>
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