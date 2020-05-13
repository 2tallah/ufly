@extends('admin.layout.app')
@section('title')
    {{__('common.admins')}}
@endsection
@section('css')
@endsection
@section('styles')
@endsection
@section('content')
    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-md-12">
                        <h2>{{__('common.edit')}} {{__('common.admin')}}</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{url('admin/admins')}}">{{__('common.admins')}}</a></li>
                            <li class="breadcrumb-item active">{{__('common.edit')}} {{__('common.admin')}}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>{{__('common.edit')}} {{__('common.admin')}}</h2>
                        </div>
                        <div class="body">
                            <form action="{{url(app()->getLocale()."/admin/admins/$admin->id")}}" id="basic-form" method="post"
                                  data-reset="false" class="ajax_form form-horizontal" enctype="multipart/form-data" novalidate>
                                {{csrf_field()}}
                                {{method_field('PUT')}}
                                <br>
                                <div class="form-body offset-2">
                                    <div class="form-group row">
                                        <label for="name" class="col-md-3 col-form-label">
                                            {{__('common.name')}}
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="name"
                                                   required name="name" value="{{$admin->name}}"
                                                   placeholder="{{__('common.name')}}">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="email" class="col-md-3 col-form-label">
                                            {{__('common.email')}}
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-6">
                                            <input type="email" class="form-control" id="email"
                                                   required name="email" value="{{$admin->email}}"
                                                   placeholder="{{__('common.email')}}">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="mobile" class="col-md-3 col-form-label">
                                            {{__('common.mobile')}}
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="mobile"
                                                   required name="mobile" value="{{$admin->mobile}}"
                                                   placeholder="{{__('common.mobile')}}">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="password" class="col-md-3 col-form-label">
                                            {{__('common.password')}}
                                        </label>
                                        <div class="col-md-6">
                                            <input type="password" class="form-control" id="password"
                                                   required name="password"
                                                   placeholder="{{__('common.password')}}">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="name" class="col-md-3 col-form-label">
                                            {{__('common.image')}}
                                        </label>
                                        <div class="col-md-6">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                                                     style="width: 200px; height: 150px;">
                                                    <img src="{{$admin->image}}" alt=""/></div>
                                                <div>
                                                    <span class="btn btn-secondary btn-file">
                                                                <span class="fileinput-new"> {{__('common.select_image')}} </span>
                                                                <span class="fileinput-exists"> {{__('common.change')}} </span>
                                                        <input type="file" name="image"></span>
                                                    <a href="javascript:;" class="btn btn-danger fileinput-exists"
                                                       data-dismiss="fileinput"> {{__('common.remove')}} </a>
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="submit_btn btn btn-primary">
                                        <i class="fa fa-spinner fa-spin" style="display: none;"></i>
                                        {{__('common.save')}}
                                    </button>
                                    <a href="{{url('/admin/admins')}}" id="cancel_btn" class="btn btn-secondary">
                                        {{__('common.cancel')}}
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('js')

@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $('#mobile').mask('00000000000000');
        })
    </script>

@endsection
