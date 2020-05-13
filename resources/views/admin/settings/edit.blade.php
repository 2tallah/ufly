@extends('admin.layout.app')
@section('title')
    {{__('common.settings')}}
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
                        <h2>{{__('common.settings')}}</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{url('admin/settings')}}">{{__('common.settings')}}</a></li>
                            <li class="breadcrumb-item active">{{__('common.settings')}}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>{{__('common.settings')}}</h2>
                        </div>
                        <div class="body">
                            <form action="{{url(app()->getLocale()."/admin/settings")}}" id="basic-form" method="post"
                                  data-reset="false" class="ajax_form form-horizontal" enctype="multipart/form-data" novalidate>
                                {{csrf_field()}}
                                {{method_field('PUT')}}
                                <br>
                                <div class="form-body offset-2">
                                    <div class="form-group row">
                                        <label for="email" class="col-md-3 col-form-label">
                                            {{__('common.email')}}
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-6">
                                            <input type="email" class="form-control" id="email"
                                                   value="{{$setting->email}}" required name="email"
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
                                                   value="{{$setting->mobile}}" required name="mobile"
                                                   placeholder="{{__('common.mobile')}}">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="background_message" class="col-md-3 col-form-label">
                                            {{__('common.background_message')}}
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="background_message"
                                                   value="{{$setting->background_message}}" required name="background_message"
                                                   placeholder="{{__('common.background_message')}}">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="affiliate_coupon_number_of_buys" class="col-md-3 col-form-label">
                                            {{__('common.affiliate_coupon_number_of_buys')}}
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="affiliate_coupon_number_of_buys"
                                                   value="{{$setting->affiliate_coupon_number_of_buys}}" required name="affiliate_coupon_number_of_buys"
                                                   placeholder="{{__('common.affiliate_coupon_number_of_buys')}}">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="affiliate_coupon_amount" class="col-md-3 col-form-label">
                                            {{__('common.affiliate_coupon_amount')}}
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="affiliate_coupon_amount"
                                                   value="{{$setting->affiliate_coupon_amount}}" required name="affiliate_coupon_amount"
                                                   placeholder="{{__('common.affiliate_coupon_amount')}}">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="type"
                                               class="col-md-3 col-form-label">@lang('common.source')
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-6">
                                            <select class="form-control" id="source" name="source"
                                                    required>
                                                <option value="">@lang('common.select')</option>
                                                <option value="1" {{$setting->source == 1 ? 'selected' : ''}}>@lang('common.both')</option>
                                                <option value="2" {{$setting->source == 2 ? 'selected' : ''}}>@lang('common.one_card')</option>
                                                <option value="3" {{$setting->source == 3 ? 'selected' : ''}}>@lang('common.stock')</option>
                                            </select>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="type"
                                               class="col-md-3 col-form-label">@lang('common.notification_method')
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-6">
                                            <select class="form-control" id="notification_method" name="notification_method"
                                                    required>
                                                <option value="">@lang('common.select')</option>
                                                <option value="1" {{$setting->wallet_notification_method == 1 ? 'selected' : ''}}>@lang('common.both')</option>
                                                <option value="2" {{$setting->wallet_notification_method == 2 ? 'selected' : ''}}>@lang('common.email')</option>
                                                <option value="3" {{$setting->wallet_notification_method == 3 ? 'selected' : ''}}>@lang('common.sms')</option>
                                            </select>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <button type="submit" class="submit_btn btn btn-primary">
                                        <i class="fa fa-spinner fa-spin" style="display: none;"></i>
                                        {{__('common.save')}}
                                    </button>
                                    <a href="{{url('/admin')}}" id="cancel_btn" class="btn btn-secondary">
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
@endsection
