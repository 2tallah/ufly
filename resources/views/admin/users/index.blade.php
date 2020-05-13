@extends('admin.layout.app')
@section('title')
    @lang('users.management')
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
                    <div class="col-lg-5 col-md-8 col-sm-12">
                        <h2>@lang('users.management')</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item active">@lang('users.management')</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>@lang('users.management')</h2>
                        </div>
                        <div class="body">
                            <div class="m-b-15">
                                <form id="search_form">
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="s_name">@lang('common.name')</label>
                                            <input type="text" class="form-control" id="s_name"
                                                   placeholder="@lang('common.name')">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="s_mobile">@lang('common.mobile')</label>
                                            <input type="text" class="form-control" id="s_mobile"
                                                   placeholder="@lang('common.mobile')">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="s_email">@lang('common.email')</label>
                                            <input type="text" class="form-control" id="s_email"
                                                   placeholder="@lang('common.email')">
                                        </div>
                                        <div class="form-group col-md-3 align-self-end">
                                            <input type="submit" id="search_btn"
                                                   class="btn btn-info" value="@lang('common.search')">
                                            <input type="submit" id="clear_btn"
                                                   class="btn btn-secondary" value="@lang('common.clear_search')">
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <div class="m-b-15">
                                <a href="{{url('admin/users/create')}}" id="info" class="btn btn-primary"><i
                                        class="fa fa-plus"></i> @lang('common.add')</a>
                                <button disabled="disabled" id="delete_btn" class="delete-btn btn btn-danger"><i
                                        class="fa fa-trash-o"></i> @lang('common.delete')</button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable">
                                    <thead>
                                    <tr>
                                        <th>
                                            <label class="fancy-checkbox">
                                                <input id="select_all" type="checkbox" name="checkbox">
                                                <span></span>
                                            </label>
                                        </th>
                                        <th>@lang('common.image')</th>
                                        <th>@lang('common.name')</th>
                                        <th>@lang('common.mobile')</th>
                                        <th>@lang('common.email')</th>
                                        <th>@lang('common.points')</th>
                                        <th>@lang('common.actions')</th>
                                    </tr>
                                    </thead>
                                </table>
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
        var url = '{{url(app()->getLocale()."/admin/users")}}/';

        var oTable = $('.dataTable').DataTable({
            "language": {
                @if(app()->isLocale('ar'))
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Arabic.json"
                @endif
            },
            'columnDefs': [
                {
                    'targets': 0,
                    "searchable": false,
                    "orderable": false
                },
            ],
            dom: 'Bliprtip',
            buttons: ['excel'],
            "order": [[1, 'asc']],
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: '{{ url('admin/users/indexTable')}}',
                data: function (d) {
                    d.name = $('#s_name').val();
                    d.mobile = $('#s_mobile').val();
                    d.email = $('#s_email').val();
                    d.id_no = $('#s_id_no').val();
                }
            },
            columns: [
                {
                    "render": function (data, type, full, meta) {
                        return '<td>' +
                            '<label class="fancy-checkbox">' +
                            '<input value="' + full.id + '" class="table_ids checkbox-tick" type="checkbox" name="table_ids[]">' +
                            '<span></span>' +
                            '</label>' +
                            '</td>';
                    }
                },
                {
                    "render": function (data, type, full, meta) {
                        return '<img width="50"  src="' + full.image + '">';
                    }
                },
                {data: 'name', name: 'name'},
                {data: 'mobile', name: 'mobile'},
                {data: 'email', name: 'email'},
                {data: 'points', name: 'points'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
        $(document).ready(function () {
            oTable.on('draw', function () {
                $("#select_all").prop("checked", false)
                $('#delete_btn').prop('disabled', 'disabled');
                $('.status_btn').prop('disabled', 'disabled');
            });



        })
    </script>

@endsection
