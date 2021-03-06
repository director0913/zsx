@extends('layouts.admin')
@section('css')
<link href="{{asset('vendors/iCheck/custom.css')}}" rel="stylesheet">
@endsection
@section('content')
@inject('userPresenter','App\Presenters\Admin\UserPresenter')
<link type="text/css" rel="stylesheet" href="{{asset('/vendors/css/easyui.css')}}">
<script type="text/javascript" src="{{asset('/vendors/jquery/jquery-2.1.1.js')}}"></script>
<script type="text/javascript" src="{{asset('/vendors/jquery/jquery.easyui.min.js')}}"></script>
 <script type="text/javascript" charset="utf-8" src="{{asset('vendors/jquery/easyui-lang-zh_CN.js')}}"></script>
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2>{!!trans('admin/user.title')!!}</h2>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('admin/dash')}}">{!!trans('admin/breadcrumb.home')!!}</a>
        </li>
        <li>
            <a href="{{url('admin/user')}}">{!!trans('admin/breadcrumb.user.list')!!}</a>
        </li>
        <li class="active">
            <strong>{!!trans('admin/breadcrumb.user.create')!!}</strong>
        </li>
    </ol>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>{!!trans('admin/user.create')!!}</h5>
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
          <form method="post" action="{{url('admin/templates/settings')}}" class="form-horizontal">
            {{csrf_field()}}
            <div class="form-group{{ $errors->has('available_start_at') ? ' has-error' : '' }}">
              <label class="col-sm-2 control-label">可用开始时间</label>
              <div class="col-sm-10">
                <input type="text" class="easyui-datetimebox form-control" name="available_start_at" value="{{old('available_start_at')?old('available_start_at'):$info['available_start_at']}}" placeholder="{{trans('admin/user.model.available_start_at')}}"  > 
                @if ($errors->has('available_start_at'))
                <span class="help-block m-b-none text-danger">{{ $errors->first('available_start_at') }}</span>
                @endif
              </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group{{ $errors->has('available_end_at') ? ' has-error' : '' }}">
              <label class="col-sm-2 control-label">可用结束时间</label>
              <div class="col-sm-10">
                <input type="text" class="easyui-datetimebox form-control" name="available_end_at" value="{{old('available_end_at')?old('available_end_at'):$info['available_end_at']}}" placeholder="{{trans('admin/user.model.available_end_at')}}" > 
                @if ($errors->has('available_end_at'))
                <span class="help-block m-b-none text-danger">{{ $errors->first('available_end_at') }}</span>
                @endif
              </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group{{ $errors->has('available_price_max') ? ' has-error' : '' }}">
              <label class="col-sm-2 control-label">到达多少钱之后可用</label>
              <div class="col-sm-10">
                <input type="available_price_max" class="form-control" name="available_price_max" value="{{old('available_price_max')?old('available_price_max'):$info['available_price_max']}}" > 
                @if ($errors->has('available_price_max'))
                <span class="help-block m-b-none text-danger">{{ $errors->first('available_price_max') }}</span>
                @endif
              </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
              <div class="col-sm-4 col-sm-offset-2">
                  <a class="btn btn-white" href="{{url()->previous()}}">{!!trans('admin/action.actionButton.cancel')!!}</a>
                  <button class="btn btn-primary" type="submit">{!!trans('admin/action.actionButton.submit')!!}</button>
              </div>
            </div>
          </form>
        </div>
    </div>
  	</div>
  </div>
</div>
@include('admin.user.modal')
@endsection
@section('js')
<script type="text/javascript" src="{{asset('vendors/iCheck/icheck.min.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/js/user/user.js')}}"></script> 
@endsection
