@extends('admin.layout.app')
@section('title')
    @lang('common.edit') @lang('common.offer')
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
                        <h2>@lang('common.offers')</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{url('admin/offers')}}">@lang('common.offers')</a></li>
                            <li class="breadcrumb-item active">@lang('common.edit') @lang('common.offer')</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>@lang('common.edit') @lang('common.offer')</h2>
                        </div>
                        <div class="body">
                            <form action="{{url(app()->getLocale()."/admin/offers/$offer->id")}}" id="basic-form" method="post"
                                  data-reset="false" class="ajax_form form-horizontal" enctype="multipart/form-data" novalidate>
                                {{csrf_field()}}
                                {{method_field('PUT')}}
                                <br>
                                <div class="form-body offset-2">
                                    <div class="form-group row">
                                        <label for="category_id" class="col-md-3 col-form-label">
                                            @lang('common.category')
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-6">
                                            <select name="category_id" id="category_id">
                                                <option selected value="">@lang('common.select')</option>
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}"
                                                        {{$offer->category_id == $category->id ? 'selected' : ''}}>
                                                        {{$category->name}}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="coupon_id" class="col-md-3 col-form-label">
                                            @lang('common.coupon')
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-6">
                                            <select name="coupon_id" id="coupon_id">
                                                <option selected value="">@lang('common.select')</option>
                                                @foreach($coupons as $coupon)
                                                    <option value="{{$coupon->id}}"
                                                        {{$offer->coupon_id == $coupon->id ? 'selected' : ''}}>
                                                        {{$coupon->name}}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="services" class="col-md-3 col-form-label">
                                            @lang('common.service')
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-6">
                                            <select name="services[]" multiple id="services">
                                                @foreach($services as $service)
                                                    <option value="{{$service->id}}"
                                                        {{in_array($service->id, $offer->services()->pluck('service_id')->toArray()) ? 'selected' : ''}}>
                                                        {{$service->name}}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                @foreach(locales() as $key => $value)
                                        <div class="form-group row{{ $errors->has('title_'.$key) ? ' has-error' : '' }}">
                                            <label for="title_{{$key}}" class="col-md-3 col-form-label">
                                                @lang('common.title') {{$value}}
                                                <span class="required"> * </span>
                                            </label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="title_{{$key}}"
                                                       value="{{$offer->getTranslation('title', $key)}}"
                                                       required name="title_{{$key}}" placeholder="@lang('common.title') {{$value}}">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                @foreach(locales() as $key => $value)
                                        <div class="form-group row{{ $errors->has('description_'.$key) ? ' has-error' : '' }}">
                                            <label for="description_{{$key}}" class="col-md-3 col-form-label">
                                                @lang('common.description') {{$value}}
                                                <span class="required"> * </span>
                                            </label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="description_{{$key}}"
                                                       value="{{$offer->getTranslation('description', $key)}}"
                                                       required name="description_{{$key}}" placeholder="@lang('common.description') {{$value}}">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                        <div class="form-group row">
                                            <label for="old_price" class="col-md-3 col-form-label">
                                                @lang('common.old_price')
                                                <span class="required"> * </span>
                                            </label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="old_price" required
                                                       name="old_price" value="{{$offer->old_price}}"
                                                       placeholder="@lang('common.old_price')">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="price" class="col-md-3 col-form-label">
                                                @lang('common.price')
                                                <span class="required"> * </span>
                                            </label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="price" required
                                                       name="price" value="{{$offer->price}}"
                                                       placeholder="@lang('common.price')">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="rating" class="col-md-3 col-form-label">
                                                @lang('common.rating')
                                                <span class="required"> * </span>
                                            </label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="rating" required
                                                       name="rating" value="{{$offer->rating}}"
                                                       placeholder="@lang('common.rating')">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>

                                    <div class="form-group row">
                                        <label for="address"
                                               class="col-md-3 col-form-label">{{__('common.search')}}
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-6">
                                            <input type="text" placeholder="{{__('common.search')}}"
                                                   id="address" name="location"
                                                   class="form-control" value="{{$offer->location}}"
                                                   required/>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="map" id="map" style="width: 100%; height: 300px;"></div>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <input type="hidden" class="form-control" name="lat"
                                                   value="{{$offer->lat}}"
                                                   id="lat" placeholder=" {{__('common.lat')}}" required>
                                            <input type="hidden" class="form-control" name="lng"
                                                   value="{{$offer->lng}}"
                                                   id="lng" placeholder=" {{__('common.lng')}}" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="image" class="col-md-3 col-form-label">
                                            @lang('common.images')
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-6">
                                            <input type="file" accept="image/*" multiple name="images[]" id="images"
                                                   class="form-control" value="" required/>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        @foreach($offer->images as $image)
                                            <div class="col-md-3">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                                                         style="width: 200px; height: 150px;">
                                                        <img src="{{$image->image}}" alt=""/></div>
                                                    <div>
                                                        <a href="#" data-id="{{$image->id}}"
                                                           class="btn btn-danger remove_field "> {{__('common.remove')}} </a>
                                                    </div>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>


                                    <button type="submit" class="submit_btn btn btn-primary">
                                        <i class="fa fa-spinner fa-spin" style="display: none;"></i>
                                        @lang('common.save')
                                    </button>
                                    <a href="{{url('/admin/offers')}}" id="cancel_btn" class="btn btn-secondary">
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
