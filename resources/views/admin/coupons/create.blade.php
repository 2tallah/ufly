@extends('admin.layout.app')
@section('title')
    @lang('common.add') @lang('common.coupon')
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
                        <h2>@lang('common.coupons')</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{url('/admin/coupons')}}">@lang('common.coupons')</a></li>
                            <li class="breadcrumb-item active">@lang('common.add') @lang('common.coupon')</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>@lang('common.add') @lang('common.coupon')</h2>
                        </div>
                        <div class="body">
                            <form action="{{url(app()->getLocale().'/admin/coupons')}}" id="basic-form" method="POST"
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
                                    <div class="form-group row">
                                        <label for="discount_amount" class="col-md-3 col-form-label">
                                            @lang('common.discount_amount')
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="discount_amount" required
                                                   name="discount_amount" placeholder="@lang('common.discount_amount')">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <button type="submit" class="submit_btn btn btn-primary">
                                        <i class="fa fa-spinner fa-spin" style="display: none;"></i>
                                        @lang('common.save')
                                    </button>
                                    <a href="{{url('/admin/coupons')}}" id="cancel_btn" class="btn btn-secondary">
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
