@extends('admin.layout.app')
@section('title')
    @lang('common.edit') @lang('users.user')
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
                        <h2>@lang('users.management')</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{url('/admin/users')}}">@lang('users.management')</a></li>
                            <li class="breadcrumb-item active">@lang('common.edit') @lang('users.user')</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>@lang('common.edit') @lang('users.user')</h2>
                        </div>
                        <div class="body">
                            <form action="{{url(app()->getLocale()."/admin/users/$user->id")}}" id="basic-form" method="post"
                                  data-reset="false" class="ajax_form form-horizontal" enctype="multipart/form-data" novalidate>
                                {{csrf_field()}}
                                {{method_field('PUT')}}
                                <div class="form-body offset-2">
                                    <div class="form-group row">
                                        <label for="name" class="col-md-3 col-form-label">@lang('common.name')
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="name" value="{{$user->name}}"
                                                   required name="name" placeholder="@lang('common.name')">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="mobile" class="col-md-3 col-form-label">@lang('common.mobile')
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="mobile" value="{{$user->mobile}}"
                                                   required name="mobile" placeholder="@lang('common.mobile')">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="email" class="col-md-3 col-form-label">@lang('common.email')
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-6">
                                            <input type="email" class="form-control" id="email" value="{{$user->email}}"
                                                   required name="email" placeholder="@lang('common.email')">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="points" class="col-md-3 col-form-label">@lang('common.points')
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-6">
                                            <input type="number" class="form-control" id="points" value="{{$user->points}}"
                                                   required name="points" placeholder="@lang('common.points')">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="password" class="col-md-3 col-form-label">@lang('common.password')
                                            {{--<span class="required"> * </span>--}}
                                        </label>
                                        <div class="col-md-6">
                                            <input type="password" minlength="6" class="form-control" id="password"
                                                   name="password" placeholder="@lang('common.password')">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="name" class="col-md-3 col-form-label">
                                            @lang('common.image')
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-6">

                                            <div class="fileinput fileinput-exists" data-provides="fileinput">
                                                <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                                                     style="width: 200px; height: 150px;">
                                                    <img src="{{$user->image}}" alt=""/></div>
                                                <div>
                                                    <span class="btn btn-secondary btn-file">
                                                                <span class="fileinput-new"> @lang('common.select_image')</span>
                                                                <span class="fileinput-exists"> @lang('common.select_image')</span>
                                                        <input type="file" name="image"></span>
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="submit_btn btn btn-primary">
                                        <i class="fa fa-spinner fa-spin" style="display: none;"></i>
                                        @lang('common.save')
                                    </button>
                                    <a href="{{url('admin/users')}}" id="cancel_btn" class="btn btn-secondary">
                                        @lang('common.cancel')
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
        })
    </script>

@endsection
