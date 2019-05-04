@extends('layouts.header')
@section('title','การค้นหา')
@section('style')
    <link href="{{asset('libs/magnific-popup/dist/magnific-popup.css')}}" rel="stylesheet">
    <style>

        .shopEach{
            padding: 20px;
            transition: 500ms;
        }

        .shopEach:hover{
            cursor: pointer;
            background-color: #f9f9f9;
        }

        .shopEach:active{
            background-color: #efefef;
        }

    </style>
@stop
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h3 class="slim-pagetitle">การค้นหา</h3>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('home')}}">หน้าหลัก</a>
                            </li>
                            <li class="breadcrumb-item active">การค้นหา</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid containerStyle">
        <div class="shadow bg-white rounded">
            <div class="card intable" style="padding-bottom: 100px">
                <div class="row mb-3">
                    @if (!empty($nameSearch))
                        <div class="col-12 col-md-2 d-flex align-items-stretch">
                            <div class="text-center searchInfo centerOfRow w-100">คำค้นหา: {{$nameSearch}}</div>
                        </div>
                    @endif
                    @if (!empty($type))
                        <div class="col-12 col-md-2 d-flex align-items-stretch">
                            <div class="text-center searchInfo centerOfRow w-100">ประเภท: {{$type}}</div>
                        </div>
                    @endif
                    @if ($range == 0)
                        <div class="col-12 col-md-2 d-flex align-items-stretch">
                            <div class="text-center searchInfo centerOfRow w-100">ในระยะ: ไม่จำกัด</div>
                        </div>
                    @else
                        <div class="col-12 col-md-2 d-flex align-items-stretch">
                            <div class="text-center searchInfo centerOfRow w-100">ในระยะ: {{$range/1000}} กิโลเมตร</div>
                        </div>
                    @endif
                </div>
                <div id="map"></div>
                <a href="{{route('search.on.map.view')}}"><button class="mt-3 btn btn-outline-danger btn-block waves-effect waves-light">ค้นหาบนแผนที่</button></a>
                <div style="margin-top: 2.5rem">
                    <h3 style="margin-bottom: 1.8rem">ผลลัพธ์การค้นหา:</h3>
                    @foreach ($results as $shop)
                        <div class="row shopEach" data-lat="{{$shop['shop_lat']}}" data-lng="{{$shop['shop_lng']}}">
                            <div class="col-12 col-md-4 col-lg-3">
                                @if ($shop['shop_photo_ref'] != null)
                                    <img class="image-popup-vertical-fit imageGrow mb-md-0 mb-3" href="https://maps.googleapis.com/maps/api/place/photo?maxwidth=500&photoreference={{$shop['shop_photo_ref']}}&key=AIzaSyCCfe5aS3YBeRqcAevRwJMzUwO5LCbZ2jk"
                                         src="https://maps.googleapis.com/maps/api/place/photo?maxwidth=200&photoreference={{$shop['shop_photo_ref']}}&key=AIzaSyCCfe5aS3YBeRqcAevRwJMzUwO5LCbZ2jk"
                                         width="200" style="max-height: 200px;max-width: 200px;display: block;margin-left: auto;margin-right: auto;"
                                         alt="store">
                                    @else
                                        <img class="image-popup-vertical-fit imageGrow mb-md-0 mb-3" href="{{asset('images/API-Logo.png')}}"
                                             src="{{asset('images/API-Logo.png')}}"
                                             width="200" style="max-height: 200px;max-width: 200px;display: block;margin-left: auto;margin-right: auto;"
                                             alt="store">
                                @endif
                            </div>
                            <div class="col-12 col-md-8 col-lg-9">
                                <h4 style="margin-bottom: 15px">{{$shop['shop_name']}}</h4>
                                <p style="margin-bottom: 12px;font-size: 15px">ที่อยู่: {{$shop['formatted_address']}}</p>
                                <p style="margin-bottom: 12px;font-size: 15px">
                                    คะแนนจากเว็บ:
                                    @if (!$shop['shop_rating'])
                                        @for ($i = 0; $i < 5; $i++)
                                            <img src="{{asset('images/star/star-off.png')}}" alt="{{$shop['shop_name']}}" width="18px" height="18px" style="object-fit: cover;margin-top: -4px">
                                        @endfor
                                        @else
                                        @for ($i = 0; $i < (int)$shop['shop_rating']; $i++)
                                            <img src="{{asset('images/star/star-on.png')}}" alt="{{$shop['shop_name']}}" width="18px" height="18px" style="object-fit: cover;margin-top: -4px">
                                        @endfor
                                    @endif
                                </p>

                                @if ($shop['shop_phone_number'] != null)
                                    <a href="tel:{{$shop['shop_phone_number']}}" style="font-size: 15px">โทร: {{str_replace('+66-','0',$shop['shop_phone_number'])}}</a>
                                @endif
                                <div style="margin-top: 14px">
                                    <a href="{{$shop['shop_url_nav']}}"
                                       class="btn btn-danger waves-effect waves-light btn-sm"
                                       target="_blank">กดเพื่อนำทาง</a>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{asset('libs/magnific-popup/dist/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('libs/magnific-popup/meg.init.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCfe5aS3YBeRqcAevRwJMzUwO5LCbZ2jk&libraries=places"></script>
    <script type="text/javascript">

        var userLat = '{{ $lat }}';
        var userLng = '{{ $lng }}';
        var userMarker;

        $(document).ready(function () {
            getPlace();
        });

        function getPlace() {
            var locations = {!! json_encode($results) !!};
            var iconUser = {
                url: '{{ URL::asset('images/MapPointer/place_user.png') }}', // url
                scaledSize: new google.maps.Size(38, 38), // scaled size
            };

            var iconPlace = {
                url: '{{ URL::asset('images/MapPointer/place_star.png') }}', // url
                scaledSize: new google.maps.Size(38, 38), // scaled size
            };

            var mapholder = document.getElementById('map');
            mapholder.style.height = '500px';
            mapholder.style.width = 'auto';

            var myOptions = {
                zoom: 12,
                center: new google.maps.LatLng(userLat, userLng),
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL}
            };

            var map = new google.maps.Map(document.getElementById("map"), myOptions);

            userMarker = new google.maps.Marker({
                position: new google.maps.LatLng(userLat, userLng),
                map: map,
                title: "คุณอยู่ที่นี่!",
                icon: iconUser,
                animation: google.maps.Animation.BOUNCE
            });

            google.maps.event.addListener(map, 'bounds_changed', function() {
                let aNord   =   map.getBounds().getNorthEast().lat();
                let aEst    =   map.getBounds().getNorthEast().lng();
                let aSud    =   map.getBounds().getSouthWest().lat();
                let aOvest  =   map.getBounds().getSouthWest().lng();
                //console.log(aNord+'-'+aEst+"-"+aSud+"-"+'-'+aOvest);
                apiAjax(aNord,aEst,aSud,aOvest);
            });


            var infowindow = new google.maps.InfoWindow();

            var marker, i;


            for (i = 0; i < locations.length; i++) {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i].shop_lat, locations[i].shop_lng),
                    map: map,
                    icon: iconPlace
                });


                google.maps.event.addListener(marker, 'click', (function (marker, i) {
                    return function () {
                        infowindow.setContent("<div id='content' style='padding: 5px'>\n" +
                            "        <h4 id='firstHeading' class='firstHeading'>"+locations[i].shop_name+"</h4>\n" +
                            "\n" +
                            "        <div id=\"bodyContent\">\n" +
                            "            <p style=\"margin-bottom: 0.25rem;font-size: 15px\">\n" +
                            "                ที่อยู่: "+locations[i].formatted_address+"\n" +
                            "            </p>\n" +
                            "            <p style=\"margin-bottom: 0.25rem;font-size: 15px\">\n" +
                            "                คะแนนจากเว็บ: "+locations[i].shop_rating.toString()+"\n" +
                            "            </p>\n" +
                            "            <a href='tel:"+locations[i][6]+"' style=\"font-size: 15px\">โทร: "+locations[i].shop_phone_number+"</a>\n" +

                            "            <div style=\"top: 10px;\"><a href='"+locations[i].shop_url_nav+"' class=\"btn btn-googleplus waves-light waves-effect btn-sm float-right\" target='_blank'>นำทาง</a></div>\n" +
                            "        </div>\n" +
                            "\n" +
                            "    </div>");
                        infowindow.open(map, marker);
                        if (marker.getAnimation() !== null) {
                            marker.setAnimation(null);
                        } else {
                            marker.setAnimation(google.maps.Animation.BOUNCE);
                            setTimeout(function () {
                                marker.setAnimation(null);
                            }, 2150);
                        }
                        map.setZoom(16);
                    }
                })(marker, i));
            }
            
            $('.shopEach').on('click tap',function () {
                let lat = parseFloat($(this).attr('data-lat'));
                let lng = parseFloat($(this).attr('data-lng'));
                map.panTo({lat: lat,lng: lng});
                map.setZoom(16);
            })
        }

        function apiAjax(aNord,aEst,aSud,aOvest) {
            $.ajax({
                url: '{!! url('/api/map/bound.api') !!}',
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {aNord: aNord,aEst: aEst,aSud: aSud,aOvest: aOvest}
            }).done(function (msg) {
                let data = JSON.parse(JSON.parse(JSON.stringify(msg)));
                console.log(data.places);
                if (data.status == true) {
                    $.each(data.model, function (index, val) {

                    });

                }
            });
        }
    </script>

@stop