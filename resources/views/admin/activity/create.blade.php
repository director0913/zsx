@extends('layouts.admin')
@section('css')
<link href="{{asset('vendors/dataTables/datatables.min.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2>创建活动</h2>
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
           @if($cut_price_lists)
                @foreach($cut_price_lists as $k => $v)
                   {{$v['title']}} {!! QrCode::size(200)->generate(url('/activity/create/'.$v['id'].'/now/'.getUerId())) !!} 
                    {{url('/activity/create/'.$v['id'].'/now/'.getUerId())}}
                @endforeach
            @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')
<script src="{{asset('vendors/dataTables/datatables.min.js')}}"></script>
<script src="{{asset('vendors/layer/layer.js')}}"></script>
@endsection