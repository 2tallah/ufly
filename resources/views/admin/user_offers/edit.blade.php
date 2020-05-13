@extends('admin.layout.app')
@section('title')
    @lang('common.edit') @lang('common.user_offer')
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
                            <li class="breadcrumb-item"><a href="{{url('admin/user_offers')}}">@lang('common.user_offers')</a></li>
                            <li class="breadcrumb-item active">@lang('common.edit') @lang('common.user_offer')</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>@lang('common.edit') @lang('common.user_offer')</h2>
                        </div>
                        <div class="body">
                            <form action="{{url(app()->getLocale()."/admin/user_offers/$user_offer->id")}}" id="basic-form" method="post"
                                  data-reset="false" class="ajax_form form-horizontal" enctype="multipart/form-data" novalidate>
                                {{csrf_field()}}
                                {{method_field('PUT')}}
                                <br>
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
                                                    <option value="{{$offer->id}}"
                                                        {{$user_offer->offer_id == $offer->id ? 'selected' : ''}}>
                                                        {{$offer->title}}</option>
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
                                                <option value="{{$user_offer->user_id}}" selected>{{$user_offer->user_name}}</option>
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
                                            <input type="text" class="form-control" id="quantity" name="quantity"
                                                   value="{{$user_offer->quantity}}" placeholder="@lang('common.quantity')" required>
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
        $(document).on("click", ".remove_field", function (e) { //user click on remove text'+
            e.preventDefault();
            var numItems = $('.remove_field').length;
            if (numItems > 1) {
                $(this).parent().parent().parent().remove();
                $('#basic-form').append('<input type="hidden" name="delete_ids[]" value="' + $(this).data('id') + '"/>')
            }
        })

        function initMap(lat, lng) {
            address_map();
            // from_address_map();
            // to_address_map();
        }

        function address_map() {
            var input = document.getElementById('address');
            var lat = parseFloat(document.getElementById('lat').value);
            var lng = parseFloat(document.getElementById('lng').value);
            var autocomplete = new google.maps.places.Autocomplete(input, {
                // types: ['(cities)'],
                componentRestrictions: {
                    country: 'sa'
                }
            });
            var geocoder = new google.maps.Geocoder;
            var infowindow = new google.maps.InfoWindow;
            var uluru = {lat: lat || 24.7253981, lng: lng || 46.2620201};
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 5,
                center: uluru
            });
            autocomplete.bindTo('bounds', map);

            // Set the data fields to return when the user selects a place.
            autocomplete.setFields(
                ['address_components', 'geometry', 'icon', 'name']);

            autocomplete.addListener('place_changed', function () {
                infowindow.close();
                marker.setVisible(false);
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    // User entered the name of a Place that was not suggested and
                    // pressed the Enter key, or the Place Details request failed.
                    return;
                }

                // If the place has a geometry, then present it on a map.
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);  // Why 17? Because it looks good.
                }
                marker.setPosition(place.geometry.location);
                marker.setVisible(true);
                document.getElementById('lat').value = place.geometry.location.lat();
                document.getElementById('lng').value = place.geometry.location.lng();
            });

            if (isNaN(lat) && isNaN(lng)) {
                marker = new google.maps.Marker({
                    map: map,
                });
            } else {
                marker = new google.maps.Marker({
                    position: uluru,
                    map: map,
                });
            }
            google.maps.event.addListener(map, "click", function (event) {
                placeMarker(event.latLng)
                getAddress(event.latLng)
            });

            function placeMarker(location) {
                if (marker === null) {
                    marker = new google.maps.Marker({
                        position: location,
                        map: map,
                    });
                }
                else {
                    marker.setPosition(location);
                }
                var latlng = {lat: parseFloat(location.lat()), lng: parseFloat(location.lng())};

                $('#lat').val(latlng.lat)
                $('#lng').val(latlng.lng)
                $('#latlngs').change()

                getAddress(location);
            }

            function getAddress(latLng) {
                geocoder.geocode({'latLng': latLng},
                    function (results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            if (results[0]) {
                                console.log(results[0].formatted_address);
                                document.getElementById("address").value = results[0].formatted_address;
                            }
                            else {
                                document.getElementById("address").value = "No results";
                            }
                        }
                        else {
                            document.getElementById("address").value = status;
                        }
                    });
            }

        }

    </script>

    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD9wmTJeQspHyBabX7npNkHrbAN7fXshmo&libraries=places&callback=initMap"
        async defer></script>
@endsection
