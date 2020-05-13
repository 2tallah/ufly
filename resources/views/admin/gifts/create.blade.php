@extends('admin.layout.app')
@section('title')
    @lang('common.add') @lang('common.gift')
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
                        <h2>@lang('common.gifts')</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{url('/admin/gifts')}}">@lang('common.gifts')</a></li>
                            <li class="breadcrumb-item active">@lang('common.add') @lang('common.gift')</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>@lang('common.add') @lang('common.gift')</h2>
                        </div>
                        <div class="body">
                            <form action="{{url(app()->getLocale().'/admin/gifts')}}" id="basic-form" method="POST"
                                  data-reset="true" class="ajax_form form-horizontal" enctype="multipart/form-data" novalidate>
                                {{csrf_field()}}
                                <div class="form-body offset-2">
                                @foreach(locales() as $key => $value)
                                        <div class="form-group row{{ $errors->has('name_'.$key) ? ' has-error' : '' }}">
                                            <label for="name_{{$key}}" class="col-md-3 col-form-label">
                                                @lang('common.name') {{$value}}
                                                <span class="required"> * </span>
                                            </label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="name_{{$key}}"
                                                       required name="name_{{$key}}"
                                                       placeholder="@lang('common.name') {{$value}}">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                @foreach(locales() as $key => $value)
                                        <div class="form-group row{{ $errors->has('details_'.$key) ? ' has-error' : '' }}">
                                            <label for="details_{{$key}}" class="col-md-3 col-form-label">
                                                @lang('common.details') {{$value}}
                                                <span class="required"> * </span>
                                            </label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="details_{{$key}}"
                                                       required name="details_{{$key}}"
                                                       placeholder="@lang('common.details') {{$value}}">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="form-group row">
                                        <label for="points" class="col-md-3 col-form-label">
                                            @lang('common.points')
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="points" required
                                                   name="points" placeholder="@lang('common.points')">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="name" class="col-md-3 col-form-label">
                                            @lang('common.image')
                                        </label>
                                        <div class="col-md-6">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                                                     style="width: 200px; height: 150px;"></div>
                                                <div>
                                                    <span class="btn btn-secondary btn-file"><span
                                                            class="fileinput-new">@lang('common.select_image')</span><span
                                                            class="fileinput-exists">@lang('common.change')</span><input
                                                            accept="image/*" type="file"
                                                            name="image"></span>
                                                    <a href="#" class="btn btn-danger fileinput-exists"
                                                       data-dismiss="fileinput">@lang('common.remove')</a>
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="submit_btn btn btn-primary">
                                        <i class="fa fa-spinner fa-spin" style="display: none;"></i>
                                        @lang('common.save')
                                    </button>
                                    <a href="{{url('/admin/gifts')}}" id="cancel_btn" class="btn btn-secondary">
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
@endsection
