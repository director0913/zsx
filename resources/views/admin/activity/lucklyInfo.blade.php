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
			            <th>奖品</th>
			            <th>中奖时间</th>
                  <th>是否核销</th>
                  <th>操作</th>
			          </tr>
		          </thead>
		          <tbody>
                @foreach($info as $k => $v)
                <tr role="row" class="odd">
                  <td class="sorting_1">{{$v['id']}}</td>
                  <td>{{$v['nickname']}}</td>
                  <td>{{$res['info']['price_title'][($v['is_luckly'] - 1)]}}</td>
                  <td>{{$v['created_at']}}</td>
                  <td>{{$v['is_sign']==1?'已核销':'未核销'}}</td>
                  
                  <td>
                    @if($v['is_sign']==1)
                    <a href="javascript:;" onclick="return false" class="btn btn-xs btn-outline btn-danger tooltips tosign" data-original-title="撤销核销" data-placement="top"><i class="fa ">撤销核销</i><form action="{{url('/admin/activity/lucklyRoolbacksign/'.$v['id'])}}" method="POST" name="delete_item" style="display:none"><input type="hidden" name="_method" value="delete"><input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"></form></a>
                    @else
                    <a href="javascript:;" onclick="return false" class="btn btn-xs btn-outline btn-danger tooltips tosign" data-original-title="核销" data-placement="top"><i class="fa ">核销</i><form action="{{url('/admin/activity/lucklyTosign/'.$v['id'])}}" method="POST" name="delete_item" style="display:none"><input type="hidden" name="_method" value="delete"><input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"></form></a>
                    @endif
                    <a href="javascript:;" onclick="return false" class="btn btn-xs btn-outline btn-danger tooltips destroy_item" data-original-title="删除" data-placement="top"><i class="fa fa-trash"></i><form action="{{url('/admin/activity/totalDel/'.$v['id'])}}" method="POST" name="delete_item" style="display:none"><input type="hidden" name="_method" value="delete"><input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"></form></a></td>
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
  $(document).on('click','.tosign',function() {
    var _item = $(this);
    var cont = $(this).find('.fa').html()
    layer.confirm('确定要'+cont+'？', {
      btn: ['确定', '取消'],
      icon: 5,
    },function(index){
      _item.children('form').submit();
      layer.close(index);
    });
  });

</script>
@endsection