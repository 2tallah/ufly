@extends('admin.layout.app')
@section('title')
    @lang('common.edit') @lang('common.service')
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
                        <h2>@lang('common.services')</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{url('admin/services')}}">@lang('common.services')</a></li>
                            <li class="breadcrumb-item active">@lang('common.edit') @lang('common.service')</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>@lang('common.edit') @lang('common.service')</h2>
                        </div>
                        <div class="body">
                            <form action="{{url(app()->getLocale()."/admin/services/$service->id")}}" id="basic-form" method="post"
                                  data-reset="false" class="ajax_form form-horizontal" enctype="multipart/form-data" novalidate>
                                {{csrf_field()}}
                                {{method_field('PUT')}}
                                <br>
                                <div class="form-body offset-2">
                                    @foreach(locales() as $key => $value)
                                        <div class="form-group row{{ $errors->has('name_'.$key) ? ' has-error' : '' }}">
                                            <label for="name_{{$key}}" class="col-md-3 col-form-label">
                                                @lang('common.name'){{$value}}
                                                <span class="required"> * </span>
                                            </label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="name_{{$key}}"
                                                       value="{{$service->getTranslation('name', $key)}}"
                                                       required name="name_{{$key}}" placeholder="@lang('common.name'){{$value}}">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                        <button type="submit" class="submit_btn btn btn-primary">
                                        <i class="fa fa-spinner fa-spin" style="display: none;"></i>
                                        @lang('common.save')
                                    </button>
                                    <a href="{{url('/admin/services')}}" id="cancel_btn" class="btn btn-secondary">
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
