@extends('admin.layout.app')
@section('title')
    @lang('common.profile')
@endsection
@section('css')
@endsection
@section('styles')
@endsection
@section('content')
    <div id="main-content" class="profilepage_1">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">
                        <h2>@lang('common.profile')</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item active">@lang('common.profile')</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="body">
                            <ul class="nav nav-tabs">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                                        href="#Settings">@lang('common.profile')</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                        href="#password">@lang('common.password')</a></li>
                            </ul>
                        </div>
                        <div class="tab-content">

                            <div class="tab-pane active" id="Settings">

                                <div class="row clearfix">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="body">
                                                <form action="{{url(app()->getLocale().'/admin/profile')}}"
                                                      id="profile-form"
                                                      data-reset="false" method="post"
                                                      class="ajax_form form-horizontal" enctype="multipart/form-data"
                                                      novalidate>
                                                    {{csrf_field()}}
                                                    {{method_field('put')}}
                                                    <div class="form-body offset-2">
                                                        {{--<div class="form-group row">--}}
                                                        {{--<div class="media">--}}
                                                        {{--<div class="media-left m-r-15">--}}
                                                        {{--<img src="../assets/images/user.png" class="user-photo media-object"--}}
                                                        {{--alt="User">--}}
                                                        {{--</div>--}}
                                                        {{--<div class="media-body">--}}
                                                        {{--<p>Upload your photo.--}}
                                                        {{--<br> <em>Image should be at least 140px x 140px</em></p>--}}
                                                        {{--<button type="button" class="btn btn-default-dark" id="btn-upload-photo">--}}
                                                        {{--Upload Photo--}}
                                                        {{--</button>--}}
                                                        {{--<input type="file" id="filePhoto" class="sr-only">--}}
                                                        {{--</div>--}}
                                                        {{--</div>--}}
                                                        {{--</div>--}}

                                                        <div class="form-group row">
                                                            <label for="name"
                                                                   class="col-md-3 col-form-label">@lang('common.name')
                                                                <span class="required"> * </span>
                                                            </label>
                                                            <div class="col-md-6">
                                                                <input type="text" name="name" id="name"
                                                                       class="form-control"
                                                                       value="{{auth()->user()->name}}"
                                                                       required/>
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="email"
                                                                   class="col-md-3 col-form-label">@lang('common.email')
                                                                <span class="required"> * </span>
                                                            </label>
                                                            <div class="col-md-6">
                                                                <input type="email" name="email" id="email"

                                                                       class="form-control"
                                                                       value="{{auth()->user()->email}}" required/>
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="mobile"
                                                                   class="col-md-3 col-form-label">@lang('common.mobile')
                                                                <span class="required"> * </span>
                                                            </label>
                                                            <div class="col-md-6">
                                                                <input type="text" name="mobile" id="mobile"

                                                                       class="form-control"
                                                                       value="{{auth()->user()->mobile}}" required/>
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="name" class="col-md-3 col-form-label">
                                                                @lang('common.image')
                                                                <span class="required"> * </span>
                                                            </label>
                                                            <div class="col-md-6">

                                                                <div class="fileinput fileinput-exists"
                                                                     data-provides="fileinput">
                                                                    <div class="fileinput-preview thumbnail"
                                                                         data-trigger="fileinput"
                                                                         style="width: 200px; height: 150px;">
                                                                        <img src="{{auth()->user()->image}}" alt=""/>
                                                                    </div>
                                                                    <div>
                                                    <span class="btn btn-secondary btn-file">
                                                                <span
                                                                    class="fileinput-new"> @lang('common.select_image')</span>
                                                                <span
                                                                    class="fileinput-exists"> @lang('common.select_image')</span>
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
                                                        <a href="{{url('/admin/profile')}}" id="cancel_btn"
                                                           class="btn btn-secondary">
                                                            @lang('common.cancel')
                                                        </a>
                                                    </div>


                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane" id="password">

                                <div class="row clearfix">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="body">
                                                <form action="{{url(app()->getLocale().'/admin/password')}}"
                                                      id="password-form"
                                                      method="post" data-reset="true"
                                                      class="ajax_form form-horizontal" enctype="multipart/form-data"
                                                      novalidate>
                                                    {{csrf_field()}}
                                                    {{method_field('put')}}
                                                    <div class="form-body offset-2">
                                                        <div class="form-group row">
                                                            <label for="current_password"
                                                                   class="col-md-3 col-form-label">@lang('common.current_password')
                                                                <span class="required"> * </span>
                                                            </label>
                                                            <div class="col-md-6">
                                                                <input type="password" name="current_password"
                                                                       id="current_password" placeholder="@lang('common.current_password')"
                                                                       class="form-control" value="" required/>
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="password"
                                                                   class="col-md-3 col-form-label">@lang('common.password')
                                                                <span class="required"> * </span>
                                                            </label>
                                                            <div class="col-md-6">
                                                                <input type="password" name="password" id="password"
                                                                       placeholder="@lang('common.password')"
                                                                       class="form-control" value="" required/>
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="password_confirmation"
                                                                   class="col-md-3 col-form-label">@lang('common.password_confirmation')
                                                                <span class="required"> * </span>
                                                            </label>
                                                            <div class="col-md-6">
                                                                <input type="password" name="password_confirmation"
                                                                       id="password_confirmation" placeholder="@lang('common.password_confirmation')"
                                                                       class="form-control" value="" required/>
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="submit_btn btn btn-primary">
                                                            <i class="fa fa-spinner fa-spin" style="display: none;"></i>
                                                            @lang('common.save')
                                                        </button>
                                                        <a href="{{url('/admin/profile')}}" id="cancel_btn"
                                                           class="btn btn-secondary">
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
        $(function () {
            // photo upload
            $('#btn-upload-photo').on('click', function () {
                $(this).siblings('#filePhoto').trigger('click');
            });

            // plans
            $('.btn-choose-plan').on('click', function () {
                $('.plan').removeClass('selected-plan');
                $('.plan-title span').find('i').remove();

                $(this).parent().addClass('selected-plan');
                $(this).parent().find('.plan-title').append('<span><i class="fa fa-check-circle"></i></span>');
            });
        });
    </script>

@endsection
