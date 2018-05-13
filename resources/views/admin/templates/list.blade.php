@extends('layouts.admin')
@section('css')
<link href="{{asset('vendors/dataTables/datatables.min.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2>{!!trans('admin/user.title')!!}</h2>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('admin/dash')}}">{!!trans('admin/breadcrumb.home')!!}</a>
        </li>
        <li class="active">
            <strong>{!!trans('admin/breadcrumb.user.list')!!}</strong>
        </li>
    </ol>
  </div>
  @permission(config('admin.permissions.user.create'))
  <div class="col-lg-2">
    <div class="title-action">
      <a href="{{url('admin/user/create')}}" class="btn btn-info">{!!trans('admin/user.action.create')!!}</a>
    </div>
  </div>
  @endpermission
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>{!!trans('admin/user.desc')!!}</h5>
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
                  <td class="sorting_1"><img src="{{$v['thumbnail_varchar']}}"></td>
                  <td>{{$v['scenename_varchar']}}</td>
                  <td>{{$v['showstatus_int']==1?'打开':'关闭'}}</td>
                  <td>{{$v['publishTime']}}</td>
                  <td>2018-04-29 15:09:11</td>
                  <td>
                    <a href="{{url('/admin/templates/preview/'.$v['sceneid_bigint'])}}" class="btn btn-xs btn-outline btn-info tooltips" data-toggle="tooltip" data-original-title="查看" data-placement="top"><i class="fa fa-eye">预览</i></a>
                    <a href="http://id.com/admin/user/1/edit" class="btn btn-xs btn-outline btn-warning tooltips" data-original-title="修改" data-placement="top"><i class="fa fa-edit">修改</i>
                    </a> 
                    <a href="javascript:;" onclick="return false" class="btn btn-xs btn-outline btn-danger tooltips destroy_item" data-original-title="删除" data-placement="top"><i class="fa fa-trash">删除</i><form action="http://id.com/admin/user/1" method="POST" name="delete_item" style="display:none"><input type="hidden" name="_method" value="delete"><input type="hidden" name="_token" value="J8z5gCRUQA8NO8Hs9SKO7iWd5KKot2v0zwSzSfa3"></form></a> 
                  </td>
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
<script src="{{asset('admin/js/templates/templates-datatable.js')}}"></script>
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