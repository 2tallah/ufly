@extends('admin.layout.app')
@section('title')
    @lang('common.add') @lang('common.user_offer')
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
                        <h2>@lang('common.user_offers')</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{url('/admin/user_offers')}}">@lang('common.user_offers')</a></li>
                            <li class="breadcrumb-item active">@lang('common.add') @lang('common.user_offer')</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>@lang('common.add') @lang('common.user_offer')</h2>
                        </div>
                        <div class="body">
                            <form action="{{url(app()->getLocale().'/admin/user_offers')}}" id="basic-form" method="POST"
                                  data-reset="true" class="ajax_form form-horizontal" enctype="multipart/form-data" novalidate>
                                {{csrf_field()}}
                                <div class="form-body offset-2">
                                    <div class="form-group row">
                                        <label for="offer_id" class="col-md-3 col-form-label">
                                            @lang('common.offer')
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-6">
                                            <select name="offer_id" id="offer_id">
                                                <option selected value="">@lang('common.select')</option>
                                                @foreach($offers as $offer)
                                                    <option value="{{$offer->id}}">{{$offer->title}}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="user_id" class="col-md-3 col-form-label">@lang('common.user')
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-6">
                                            <select class="user_id form-control" id="user_id" name="user_id"
                                                    required>
                                            </select>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="quantity" class="col-md-3 col-form-label">
                                            @lang('common.quantity')
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="quantity" required
                                                   name="quantity" placeholder="@lang('common.quantity')">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>

                                    <button type="submit" class="submit_btn btn btn-primary">
                                        <i class="fa fa-spinner fa-spin" style="display: none;"></i>
                                        @lang('common.save')
                                    </button>
                                    <a href="{{url('/admin/user_offers')}}" id="cancel_btn" class="btn btn-secondary">
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
            $('#user_id').select2({
            dir: '{{LaravelLocalization::getCurrentLocaleDirection()}}',
            placeholder: "@lang('common.select')",
            minimumInputLength: 3,
            ajax: {
                url: '{{url('admin/get_user')}}',
                dataType: 'json',
                data: function (params) {
                    return {
                        q: $.trim(params.term),
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true,
            }
        });
        });

    </script>
@endsection
