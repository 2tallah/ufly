@extends('admin.layout.app')
@section('title')
    {{__('common.dashboard')}}
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
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"></a>{{__('common.dashboard')}}</h2>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-3 col-md-6">
                    <div class="card top_counter">
                        <div class="body">
                            <div class="icon text-info"><i class="fa fa-users"></i> </div>
                            @php($customers = \App\User::query()->count())
                            <div class="content">
                                <div class="text">{{__('users.users')}}</div>
                                <h5 class="number">{{\App\User::query()->count()}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card top_counter">
                        <div class="body">
                            <div class="icon text-danger"><i class="fa fa-credit-card"></i> </div>
                            <div class="content">
                                <div class="text">{{__('cards.cards')}}</div>
                                <h5 class="number">{{\App\Models\Card::query()->count()}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                @php($my_cards = \App\Models\MyCard::query()->get())
                <div class="col-lg-3 col-md-6">
                    <div class="card top_counter">
                        <div class="body">
                            <div class="icon text-warning"><i class="fa fa-shopping-cart"></i> </div>
                            <div class="content">
                                <div class="text">{{__('common.purchased_count')}}</div>
                                <h5 class="number">{{$my_cards->count()}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card top_counter">
                        <div class="body">
                            <div class="icon text-success"><i class="fa fa-money"></i> </div>
                            <div class="content">
                                <div class="text">{{__('common.purchased_amount')}}</div>
                                <h5 class="number">{{$my_cards->sum('total')}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card top_counter">
                        <div class="body">
                            <div class="icon text-success"><i class="fa fa-money"></i> </div>
                            <div class="content">
                                <div class="text">{{__('common.purchased_amount')}}</div>
                                <h5 class="number">{{$my_cards->sum('total') - $my_cards->sum('provider_total')}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>{{__('common.most_purchased_cards')}}</h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover m-b-0">
                                    <tbody>
                                    <tr>
                                        <td>@lang('common.name')</td>
                                        <td>@lang('cards.value')</td>
                                        <td>@lang('cards.duration')</td>
                                        <td>@lang('cards.price')</td>
                                        <td>@lang('cards.product_code')</td>
                                        <td>@lang('common.count')</td>
                                    </tr>

                                    @foreach($most_cards as $card)
                                        <tr>
                                            <td><a target="_blank" href="{{url("admin/cards/$card->id/edit")}}">{{$card->name}}</a></td>
                                            <td>{{$card->value}}</td>
                                            <td>{{$card->duration}}</td>
                                            <td>{{$card->total}}</td>
                                            <td>{{$card->product_code}}</td>
                                            <td>{{$card->user_cards_count}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{--
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12">
                                <div class="card">
                                    <div class="header">
                                        <h2>{{__('common.latest')}} {{__('common.requests')}}</h2>
                                    </div>
                                    <div class="body">
                                        <div class="table-responsive">
                                            <table class="table table-hover m-b-0">
                                                <tbody>
                                                @foreach($latest_requests as $request)
                                                    <tr>
                                                        <td><img width="50" src="{{$request->image}}" alt=""></td>
                                                        <td>{{$request->description}}</td>
                                                        <td>{{$request->user->name}}</td>
                                                        <td><a href="{{url("admin/service_requests/$request->request_no/edit")}}"><span>{{__('common.view')}}</span></a></td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12 col-md-4 col-lg-6">
                                <div class="card">
                                    <div class="header">
                                        <h2>{{__('common.city_request_count')}}
                                        </h2>
                                    </div>
                                    <div class="body">
                                        <div style="width: 100%; height: 300px; direction: ltr" id="city_request_count"></div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-6">
                                <div class="card">
                                    <div class="header">
                                        <h2>{{__('common.category_request_count')}}
                                        </h2>
                                    </div>
                                    <div class="body">
                                        <div style="width: 100%; height: 300px; direction: ltr" id="category_request_count"></div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-6">
                                <div class="card">
                                    <div class="header">
                                        <h2>{{__('common.condition_request_count')}}
                                        </h2>
                                    </div>
                                    <div class="body">
                                        <div style="width: 100%; height: 300px; direction: ltr" id="condition_request_count"></div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-6">
                                <div class="card">
                                    <div class="header">
                                        <h2>{{__('common.city_tool_count')}}
                                        </h2>
                                    </div>
                                    <div class="body">
                                        <div style="width: 100%; height: 300px; direction: ltr" id="city_tool_count"></div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-6">
                                <div class="card">
                                    <div class="header">
                                        <h2>{{__('common.category_tool_count')}}
                                        </h2>
                                    </div>
                                    <div class="body">
                                        <div style="width: 100%; height: 300px; direction: ltr" id="category_tool_count"></div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-6">
                                <div class="card">
                                    <div class="header">
                                        <h2>{{__('common.condition_tool_count')}}
                                        </h2>
                                    </div>
                                    <div class="body">
                                        <div style="width: 100%; height: 300px; direction: ltr" id="condition_tool_count"></div>

                                    </div>
                                </div>
                            </div>
                        </div>
            --}}

            {{--
                        <div class="row clearfix">
                            <div class="col-lg-3 col-md-6">
                                <div class="card overflowhidden">
                                    <div class="body">
                                        @php($customers = \App\User::query()->where('user_type', 1)->count())
                                        <h3>{{\App\User::query()->where('user_type', 1)->count()}}
                                            <i class="icon-users float-right"></i></h3>
                                        <span>{{__('common.customers')}}</span>
                                    </div>
                                    <div class="progress progress-xs progress-transparent custom-color-blue m-b-0">
                                        <div class="progress-bar" data-transitiongoal="64"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="card overflowhidden">
                                    <div class="body">
                                        <h3>{{\App\User::query()->where('user_type', 2)->count()}}
                                            <i class="icon-users float-right"></i></h3>
                                        <span>{{__('common.vendors')}}</span>
                                    </div>
                                    <div class="progress progress-xs progress-transparent custom-color-purple m-b-0">
                                        <div class="progress-bar" data-transitiongoal="67"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="card overflowhidden">
                                    <div class="body">
                                        <h3>{{\App\Models\Tool::query()->count()}}
                                            <i class="icon-wrench float-right"></i></h3>
                                        <span>{{__('common.tools')}}</span>
                                    </div>
                                    <div class="progress progress-xs progress-transparent custom-color-yellow m-b-0">
                                        <div class="progress-bar" data-transitiongoal="89"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="card overflowhidden">
                                    <div class="body">
                                        <h3>{{\App\Models\ServiceRequest::query()->count()}} <i class=" icon-basket float-right"></i></h3>
                                        <span>{{__('common.requests')}}</span>
                                    </div>
                                    <div class="progress progress-xs progress-transparent custom-color-green m-b-0">
                                        <div class="progress-bar" data-transitiongoal="68"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
            --}}



        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>

@endsection
@section('scripts')

    {{--<script>--}}
        {{--var city_request_count = AmCharts.makeChart( "city_request_count", {--}}
            {{--"type": "pie",--}}
            {{--"theme": "light",--}}
            {{--"labelsEnabled": false,--}}
            {{--"legend": {--}}
                {{--"position": "right"--}}
            {{--},--}}
            {{--"dataProvider": @json($city_request_count),--}}
            {{--"valueField": "count",--}}
            {{--"titleField": "city",--}}
        {{--} );--}}
        {{--var category_request_count = AmCharts.makeChart( "category_request_count", {--}}
            {{--"type": "pie",--}}
            {{--"theme": "light",--}}
            {{--"labelsEnabled": false,--}}
            {{--"legend": {--}}
                {{--"position": "right"--}}
            {{--},--}}
            {{--"dataProvider": @json($category_request_count),--}}
            {{--"valueField": "count",--}}
            {{--"titleField": "category",--}}
        {{--} );--}}
        {{--var condition_request_count = AmCharts.makeChart( "condition_request_count", {--}}
            {{--"type": "pie",--}}
            {{--"theme": "light",--}}
            {{--"labelsEnabled": false,--}}
            {{--"legend": {--}}
                {{--"position": "right"--}}
            {{--},--}}
            {{--"dataProvider": @json($condition_request_count),--}}
            {{--"valueField": "count",--}}
            {{--"titleField": "condition",--}}
        {{--} );--}}
        {{--var city_tool_count = AmCharts.makeChart( "city_tool_count", {--}}
            {{--"type": "pie",--}}
            {{--"theme": "light",--}}
            {{--"labelsEnabled": false,--}}
            {{--"legend": {--}}
                {{--"position": "right"--}}
            {{--},--}}
            {{--"dataProvider": @json($city_tool_count),--}}
            {{--"valueField": "count",--}}
            {{--"titleField": "city",--}}
        {{--} );--}}
        {{--var category_tool_count = AmCharts.makeChart( "category_tool_count", {--}}
            {{--"type": "pie",--}}
            {{--"theme": "light",--}}
            {{--"labelsEnabled": false,--}}
            {{--"legend": {--}}
                {{--"position": "right"--}}
            {{--},--}}
            {{--"dataProvider": @json($category_tool_count),--}}
            {{--"valueField": "count",--}}
            {{--"titleField": "category",--}}
        {{--} );--}}
        {{--var condition_tool_count = AmCharts.makeChart( "condition_tool_count", {--}}
            {{--"type": "pie",--}}
            {{--"theme": "light",--}}
            {{--"labelsEnabled": false,--}}
            {{--"legend": {--}}
                {{--"position": "right"--}}
            {{--},--}}
            {{--"dataProvider": @json($condition_tool_count),--}}
            {{--"valueField": "count",--}}
            {{--"titleField": "condition",--}}
        {{--} );--}}
    {{--</script>--}}

@endsection
