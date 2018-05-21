@extends('layouts.admin')
@section('css')
<link href="{{asset('vendors/dataTables/datatables.min.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2>微表单列表</h2>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('admin/dash')}}">{!!trans('admin/breadcrumb.home')!!}</a>
        </li>
        <li class="active">
            <strong>{!!trans('admin/breadcrumb.user.list')!!}</strong>
        </li>
    </ol>
  </div>
 <!--  @permission(config('admin.permissions.user.create'))
  <div class="col-lg-2">
    <div class="title-action">
      <a href="{{url('admin/user/create')}}" class="btn btn-info">{!!trans('admin/user.action.create')!!}</a>
    </div>
  </div>
  @endpermission -->
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <a href="{{url('/admin/form/lists/')}}"><span>所有模版</span></a>
          @if($templates_typeLists)
            @foreach($templates_typeLists as $k =>$v)
              <a href="{{url('/admin/form/lists/1/'.$v['id'])}}"><span>{{$v->name}}</span></a>
            @endforeach
          @endif
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
			            <th>{{trans('admin/user.model.id')}}</th>
			            <th>{{trans('admin/user.model.name')}}</th>
			            <th>{{trans('admin/user.model.username')}}</th>
			            <th>{{trans('admin/user.model.created_at')}}</th>
			            <th>{{trans('admin/user.model.updated_at')}}</th>
			            <th>{{trans('admin/action.title')}}</th>
			          </tr>
		          </thead>
		          <tbody>
                @foreach($responseData['data'] as $k => $v)

                <tr role="row" class="odd">
                  <td class="sorting_1">{{$v['id']}}</td>
                  <td>{{$v['title']}}</td>
                  <td>{{$v['is_show']==1?'打开':'关闭'}}</td>
                  <td>{{$v['created_at']}}</td>
                  <td>{{$v['updated_at']}}</td>
                  <td>{!! $v['action'] !!}</td>
                </tr>
                @endforeach
		          </tbody>
	          </table>
          </div>
        </div>
        <div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate">
          <ul class="pagination">
            @if($responseData['length']>1)
              <li class="paginate_button first" id="DataTables_Table_0_first"><a href="{{url('/admin/form/lists/1/'.$id)}}" aria-controls="DataTables_Table_0" data-dt-idx="0" tabindex="0">首页</a></li>
              <li class="paginate_button previous" id="DataTables_Table_0_previous"><a href="{{url('/admin/form/lists/'.($p-1==0?1:$p-1).'/'.$id)}}" aria-controls="DataTables_Table_0" data-dt-idx="1" tabindex="0">上页</a></li>
              @for($i=1;$i-1<$responseData['length'];$i++)
                <li class="paginate_button @if($p==$i) active @endif"><a href="{{url('/admin/form/lists/'.$i.'/'.$id)}}" aria-controls="DataTables_Table_0" data-dt-idx="2" tabindex="0">{{$i}}</a></li>
              @endfor
              <li class="paginate_button next" id="DataTables_Table_0_next"><a href="{{url('/admin/form/lists/'.($p+1<=$responseData['length']?$p+1:$responseData['length']).'/'.$id)}}" aria-controls="DataTables_Table_0" data-dt-idx="7" tabindex="0">下页</a></li><li class="paginate_button last" id="DataTables_Table_0_last"><a href="{{url('/admin/form/lists/'.$responseData['length'].'/'.$id)}}" aria-controls="DataTables_Table_0" data-dt-idx="8" tabindex="0">末页</a></li>
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
</script>
@endsection