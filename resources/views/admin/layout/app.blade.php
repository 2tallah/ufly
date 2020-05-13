<!doctype html>
<html lang="en">

<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- VENDOR CSS -->
    <link href="https://fonts.googleapis.com/css?family=Cairo:300,400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}">
    @if(LaravelLocalization::getCurrentLocaleDirection() == 'rtl')
        <link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.rtl.css')}}">
    @endif
    <link rel="stylesheet" href="{{asset('assets/vendor/font-awesome/css/font-awesome.min.css')}}">

    <link rel="stylesheet" href="{{asset('assets/vendor/datatables/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/datatables/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/3.0.3/metisMenu.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css"/> {{--
            <link href="{{asset('assets/vendor/dataTables-checkboxes/dataTables-checkboxes.css')}}"
                  rel="stylesheet" type="text/css"/>
        --}}
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/awesome-bootstrap-checkbox/0.3.7/awesome-bootstrap-checkbox.css">--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastr/build/toastr.min.css">
    <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="https://www.amcharts.com/lib/3/pie.js"></script>
    <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all"/>
    <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>

    <style>
        #chartdiv {
            width: 100%;
            height: 500px;
        }

        .user-account .dropdown .dropdown-menu {
            transform: none !important;
            border: none;
            box-shadow: 0px 2px 20px 0px rgba(0, 0, 0, 0.5);
            padding: 10px !important;
            background: #17191c;
            border-radius: .55rem;
        }
    </style>

    @yield('css')
<!-- MAIN CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
    @if(LaravelLocalization::getCurrentLocaleDirection() == 'rtl')
        <link rel="stylesheet" href="{{asset('assets/css/rtl.css')}}">
    @endif
    <link rel="stylesheet" href="{{asset('assets/css/color_skins.css')}}">
    <style>
        table.table-bordered.dataTable th:last-child, table.table-bordered.dataTable th:last-child, table.table-bordered.dataTable td:last-child, table.table-bordered.dataTable td:last-child {
            border-right-width: 1px;
        }

        *:not(i) {
            font-family: 'Cairo', sans-serif !important;
        }

        .bootstrap-timepicker-widget a.btn, .bootstrap-timepicker-widget input {
            /* border-radius: 4px; */
            border: 0;
        }

        td.details-control {
            background: url('{{asset('assets/images/details_open.png')}}') no-repeat center center;
            cursor: pointer;
        }

        tr.shown td.details-control {
            background: url('{{asset('assets/images/details_close.png')}}') no-repeat center center;
        }

        table.dataTable tbody > tr.selected, table.dataTable tbody > tr > .selected {
            background-color: #49c5b6;
        }

        .col-form-label .required, .form-group .required {
            color: #e02222;
            font-size: 12px;
            padding-left: 2px;
        }

        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: .25rem;
            font-size: 80%;
            color: #dc3545;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 33px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 34px;
        }

        .select2-container--default .select2-selection--single {
            height: 35px;
        }
        .fileinput-preview.thumbnail {
            width: 200px!important;
            line-height: 145px!important;
            border: 1px solid #6c757d;
        }
        .fileinput .thumbnail>img {
            max-width: 100%;
            max-height: 100%;
        }
        .select2-container{
            width: 100% !important;
        }
        .rtl #left-sidebar .user-account {
            text-align: center;
        }

    </style>
    @yield('styles')
</head>
<body class="theme-green {{LaravelLocalization::getCurrentLocaleDirection()}}">


<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30"><img src="{{asset('assets/images/logo.svg')}}" style="width: 100px" alt="Lucid">
        </div>
        {{--<p>Please wait...</p>--}}
    </div>
</div>
<!-- Overlay For Sidebars -->

<div id="wrapper">

    <nav class="navbar navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-btn">
                <button type="button" class="btn-toggle-offcanvas"><i class="lnr lnr-menu fa fa-bars"></i></button>
            </div>

            <div class="navbar-brand">
                <a href="{{url('/')}}"><img src="{{asset('assets/images/logo.svg')}}"
                                            alt="Lucid Logo"
                                            {{--style="width: 119px; max-height: 53px"--}}
                                            class="img-responsive logo"></a>
            </div>

            <div class="navbar-right">

                <div id="navbar-menu">
                    <ul class="nav navbar-nav">
                        <li class="user-account" style="margin-top: 0; margin-bottom: 0;margin-right: 10px">
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle user-name" data-toggle="dropdown">
                                    <strong>{{auth('admin')->user()->name}}</strong>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right account">
                                    <li><a href="{{url('admin/profile')}}"><i class="icon-drawer"></i>@lang('common.profile')
                                        </a></li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="" onclick="event.preventDefault();
                                                         document.getElementsByClassName('logout-form').submit();">
                                            <i class="icon-power"></i>@lang('common.logout')
                                        </a>
                                        <form class="logout-form" action="{{ route('admin_logout') }}" method="POST"
                                              style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="user-account" style="margin-top: 0; margin-bottom: 0;margin-right: 10px">
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle user-name" data-toggle="dropdown">
                                    <strong>{{ LaravelLocalization::getCurrentLocaleNative() }}</strong>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right account">
                                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                        <li>
                                            <a hreflang="{{ $localeCode }}"
                                               href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                                {{ $properties['native'] }}
                                            </a>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="" class="icon-menu"
                               onclick="event.preventDefault();
                                                         document.getElementsByClassName('logout-form').submit();">
                                <i class="icon-logout"></i>
                            </a>
                            {{--<a href="page-login.html" class="icon-menu"><i class="icon-logout"></i></a>--}}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div id="left-sidebar" class="sidebar">
        <div class="sidebar-scroll">
            <div class="user-account">
                <img src="{{auth('admin')->user()->image}}" class="rounded-circle user-photo"
                     alt="User Profile Picture">
                <div class="dropdown">
                    <span>@lang('common.welcome'),</span>
                    <a href="#" class="dropdown-toggle user-name" data-toggle="dropdown">
                        <strong>{{auth('admin')->user()->name}}</strong>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right account">
                        <li><a href="{{url('admin/profile')}}"><i class="icon-drawer"></i>@lang('common.profile')</a></li>
                        <li class="divider"></li>
                        <li>
                            <a href=""
                               onclick="event.preventDefault();
                                                         document.getElementsByClassName('logout-form').submit();">
                                <i class="icon-power"></i>@lang('common.logout')
                            </a>
                            <form class="logout-form" action="{{ route('admin_logout') }}" method="POST"
                                  style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            <nav id="left-sidebar-nav" class="sidebar-nav">
                <ul id="main-menu" class="metismenu">
                    <li class="{{explode('/',\Request::path())[2] == 'user_gifts' ? 'active' : '' }}">
                        <a href="{{url('/admin/user_gifts')}}">
                            <i class="icon-drawer"></i>
                            <span>@lang('common.user_gifts')</span>
                        </a>
                    </li>
                    <li class="{{explode('/',\Request::path())[2] == 'gifts' ? 'active' : '' }}">
                        <a href="{{url('/admin/gifts')}}">
                            <i class="icon-drawer"></i>
                            <span>@lang('common.gifts')</span>
                        </a>
                    </li>
                    <li class="{{explode('/',\Request::path())[2] == 'user_offers' ? 'active' : '' }}">
                        <a href="{{url('/admin/user_offers')}}">
                            <i class="icon-drawer"></i>
                            <span>@lang('common.user_offers')</span>
                        </a>
                    </li>
                    <li class="{{explode('/',\Request::path())[2] == 'offers' ? 'active' : '' }}">
                        <a href="{{url('/admin/offers')}}">
                            <i class="icon-drawer"></i>
                            <span>@lang('common.offers')</span>
                        </a>
                    </li>
                    <li class="{{explode('/',\Request::path())[2] == 'services' ? 'active' : '' }}">
                        <a href="{{url('/admin/services')}}">
                            <i class="icon-drawer"></i>
                            <span>@lang('common.services')</span>
                        </a>
                    </li>
                    <li class="{{explode('/',\Request::path())[2] == 'coupons' ? 'active' : '' }}">
                        <a href="{{url('/admin/coupons')}}">
                            <i class="icon-drawer"></i>
                            <span>@lang('common.coupons')</span>
                        </a>
                    </li>
                    <li class="{{explode('/',\Request::path())[2] == 'categories' ? 'active' : '' }}">
                        <a href="{{url('/admin/categories')}}">
                            <i class="icon-drawer"></i>
                            <span>@lang('common.categories')</span>
                        </a>
                    </li>
                    <li class="{{explode('/',\Request::path())[2] == 'users' ? 'active' : '' }}">
                        <a href="{{url('/admin/users')}}">
                            <i class="icon-drawer"></i>
                            <span>@lang('common.users')</span>
                        </a>
                    </li>
                    <li class="{{explode('/',\Request::path())[2] == 'admins' ? 'active' : '' }}">
                        <a href="{{url('/admin/admins')}}">
                            <i class="icon-drawer"></i>
                            <span>@lang('common.admins')</span>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
    </div>

    @yield('content')

</div>

<!-- Javascript -->
<script src="{{asset('assets/bundles/libscripts.bundle.js')}}"></script>
<script src="https://code.jquery.com/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-sparklines/2.1.2/jquery.sparkline.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/3.0.3/metisMenu.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2/dist/js/select2.full.min.js"></script>
@if(app()->isLocale('ar'))
    <script src="https://cdn.jsdelivr.net/npm/select2/dist/js/i18n/ar.js"></script>
@endif
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.js"></script>

<script src="{{asset('assets/bundles/mainscripts.bundle.js')}}"></script>

<script src="{{asset('assets/vendor/datatables/datatables.min.js')}}"></script>
<script src="{{asset('assets/vendor/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/vendor/dataTables-checkboxes/dataTables-checkboxes.min.js')}}"></script>
{{--<script src="https://cdn.jsdelivr.net/npm/sweetalert2/dist/sweetalert2.all.min.js"></script>--}}

@yield('js')

<script>
    var selectedIds = function () {
        return $("input[name='table_ids[]']:checked").map(function () {
            return this.value;
        }).get();
    };
    $('select').select2({
        dir: '{{LaravelLocalization::getCurrentLocaleDirection()}}',
        placeholder: "@lang('common.select')",
    });
    $(document).ready(function () {
        $(document).on('change', "#select_all", function (e) {
            this.checked ? $(".table_ids").each(function () {
                this.checked = true
            }) : $(".table_ids").each(function () {
                this.checked = false
            })
            $('#delete_btn').attr('data-id', selectedIds().join());
            $('.status_btn').attr('data-id', selectedIds().join());
            if (selectedIds().join().length) {
                $('#delete_btn').prop('disabled', '');
                $('.status_btn').prop('disabled', '');
            } else {
                $('#delete_btn').prop('disabled', 'disabled');
                $('.status_btn').prop('disabled', 'disabled');
            }
        });

        $(document).on('change', ".table_ids", function (e) {
            if ($(".table_ids:checked").length === $(".table_ids").length) {
                $("#select_all").prop("checked", true)
            } else {
                $("#select_all").prop("checked", false)
            }
            $('#delete_btn').attr('data-id', selectedIds().join());
            $('.status_btn').attr('data-id', selectedIds().join());
            console.log(selectedIds().join().length)
            if (selectedIds().join().length) {
                $('#delete_btn').prop('disabled', '');
                $('.status_btn').prop('disabled', '');
            } else {
                $('#delete_btn').prop('disabled', 'disabled');
                $('.status_btn').prop('disabled', 'disabled');
            }
        });
        $('#search_btn').on('click', function (e) {
            oTable.draw();
            e.preventDefault();
        });
        $('#clear_btn').on('click', function (e) {
            $('#search_form')[0].reset();
            $('select').val("").trigger("change")
            oTable.draw();
            e.preventDefault();
        });
        $(document).on("click", ".delete-btn", function (e) {
            e.preventDefault();
            var urls = url + $(this).data('id');
            $.confirm({
                title: '@lang('common.delete_confirmation')',
                content: '@lang('common.confirm_delete')',
                escapeKey: true,
                // autoClose: true,
                closeIcon: true,
                rtl: "{{LaravelLocalization::getCurrentLocaleDirection() == 'rtl'}}",
                buttons: {
                    cancel: {
                        text: '@lang('common.cancel')',
                        btnClass: 'btn-default',
                        action: function () {
                            toastr.info('@lang('common.delete_canceled')')
                        }
                    },
                    confirm: {
                        text: '@lang('common.delete')',
                        btnClass: 'btn-red',
                        action: function () {
                            $.ajax({
                                url: urls,
                                method: 'DELETE',
                                type: 'DELETE',
                                data: {
                                    _token: '{{csrf_token()}}'
                                },
                            }).done(function (data) {
                                if (data.status) {
                                    toastr.success('@lang('common.deleted')');
                                    oTable.draw();
                                } else {
                                    toastr.warning('@lang('common.not_deleted')');
                                }

                            }).fail(function () {
                                toastr.error('@lang('common.something_wrong')');
                            });
                        }
                    }
                }
            });
        });

        $(document).on('submit', '.ajax_form', function (e) {
            // $('.submit_btn').prop('disabled', true);
            e.preventDefault();
            var form = $(this);
            var url = $(this).attr('action');
            var method = $(this).attr('method');
            var reset = $(this).data('reset');
            var Data = new FormData(this);
            $('.submit_btn').attr('disabled', 'disabled');
            $('.fa-spinner.fa-spin').show();
            $.ajax({
                url: url,
                type: method,
                data: Data,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('.invalid-feedback').html('');
                    $('.is-invalid ').removeClass('is-invalid');
                    form.removeClass('was-validated');
                }
            }).done(function (data) {
                if (data.status) {
                    toastr.success('@lang('common.done_successfully')');
                    if (reset === 'true') {
                        form[0].reset();
                    }
                    var url = $('#cancel_btn').attr('href');
                    window.location.replace(url);
                } else {
                    if (data.message) {
                        toastr.error(data.message);
                    } else {
                        toastr.error('@lang('common.something_wrong')');
                    }
                    $('.submit_btn').removeAttr('disabled');
                    $('.fa-spinner.fa-spin').hide();
                }
            }).fail(function (data) {
                if (data.status === 422) {
                    var response = data.responseJSON;
                    $.each(response.errors, function (key, value) {
                        var str = (key.split("."));
                        if (str[1] === '0') {
                            key = str[0] + '[]';
                        }
                        console.log(key);
                        $('[name="' + key + '"], [name="' + key + '[]"]').addClass('is-invalid');
                        $('[name="' + key + '"], [name="' + key + '[]"]').closest('.form-group').find('.invalid-feedback').html(value[0]);
                    });
                } else {
                    toastr.error('@lang('common.something_wrong')');
                }
                $('.submit_btn').removeAttr('disabled');
                $('.fa-spinner.fa-spin').hide();

            });
        });

        $(document).on('click', '.status_btn', function (e) {
            var urls = url + 'update_status';
            var status = $(this).val();
            $.ajax({
                url: urls,
                method: 'PUT',
                type: 'PUT',
                data: {
                    ids: $(this).data('id'),
                    status: status,
                    _token: '{{csrf_token()}}'
                },
                success: function (data) {
                    if (data.status) {
                        toastr.success('@lang('common.done_successfully')');
                        oTable.draw();
                    } else {
                        toastr.error('@lang('common.something_wrong')');
                    }
                }
            });
        });

    });

</script>
@yield('scripts')
</body>
</html>
