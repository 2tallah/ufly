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
                    <div class="col-lg-5 col-md-8 col-sm-12">
                        <h2>{{__('common.admins')}}</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('admin/')}}"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item active">{{__('common.admins')}}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>{{__('common.admins')}}</h2>
                        </div>
                        <div class="body">
                            <div class="m-b-15">
                                <form id="search_form">
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="s_name">{{__('common.name')}}</label>
                                            <input type="text" class="form-control" id="s_name" placeholder="{{__('common.name')}}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="s_email">{{__('common.email')}}</label>
                                            <input type="text" class="form-control" id="s_email" placeholder="{{__('common.email')}}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="s_mobile">{{__('common.mobile')}}</label>
                                            <input type="text" class="form-control" id="s_mobile" placeholder="{{__('common.mobile')}}">
                                        </div>
                                        <div class="form-group col-md-3 align-self-end">
                                            <input type="submit" id="search_btn"
                                                    class="btn btn-info" value="{{__('common.search')}}">
                                            <input type="submit" id="clear_btn"
                                                    class="btn btn-secondary" value="{{__('common.clear_search')}}">
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <div class="m-b-15">
                                <a href="{{url('admin/admins/create')}}" id="info" class="btn btn-primary"><i
                                        class="fa fa-plus"></i> {{__('common.add')}}</a>
                                <button disabled="disabled" id="delete_btn" class="delete-btn btn btn-danger"><i
                                        class="fa fa-trash-o"></i> {{__('common.delete')}}</button>
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
                                        <th>{{__('common.id')}}</th>
                                        <th>{{__('common.image')}}</th>
                                        <th>{{__('common.name')}}</th>
                                        <th>{{__('common.email')}}</th>
                                        <th>{{__('common.mobile')}}</th>
                                        <th>{{__('common.actions')}}</th>
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
        var url = '{{url(app()->getLocale()."/admin/admins")}}/';

        var oTable = $('.dataTable').DataTable({
            "language": {
                @if(app()->isLocale('ar'))
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Arabic.json"
                @endif
            },
            'columnDefs': [
                {
                    "targets": 1,
                    "visible": false
                },
                {
                    'targets': 0,
                    "searchable": false,
                    "orderable": false
                },
            ],
            dom: 'liprtip',
            "order": [[1, 'asc']],
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: '{{ url('/admin/admins/indexTable')}}',
                data: function (d) {
                    d.name = $('#s_name').val();
                    d.email = $('#s_email').val();
                    d.mobile = $('#s_mobile').val();
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
                {data: 'id', name: 'id'},
                {
                    "render": function (data, type, full, meta) {
                        return '<img width="50"  src="' + full.image + '">';
                    }
                },
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'mobile', name: 'mobile'},
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
