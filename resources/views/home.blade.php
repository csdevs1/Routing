@extends('layouts.app')
@section('title', 'Inicio')
@if(Auth::check())
@section('content')
    <style>
.TruckLoader {
    position: relative;
    top:150px;
    width: 150px;
    height: 40px;
    background: #444;
    animation: put-put 2s infinite, move-truck 10s infinite;
    background-size: 100% auto;
    border-radius: 4px;
    -webkit-box-reflect: below 15px -webkit-gradient(linear, left top, left bottom, from(transparent), color-stop(0.1, transparent), to(rgba(255, 255, 255, 0.1)));
}
.TruckLoader:before, .TruckLoader:after {
    content: '';
    display: block;
    border-radius: 50%;
    width: 16px;
    height: 16px;
    border: 2px solid #fff;
    background: #333;
    position: absolute;
    bottom: -10px;
}
.TruckLoader:before {
    left: 6px;
}
.TruckLoader:after {
    right: 6px;
}
.TruckLoader-cab {
    position: absolute;
    left: -35px;
    bottom: 0;
    width: 33px;
    height: 25px;
    background: #333;
    border-radius: 40% 0 4px 4px;
    -webkit-box-reflect: below 15px -webkit-gradient(linear, left top, left bottom, from(transparent), color-stop(0.1, transparent), to(rgba(255, 255, 255, 0.1)));
}
.TruckLoader-cab:before, .TruckLoader-cab:after {
    position: absolute;
    content: '';
    display: block;
    background: #333;
}
.TruckLoader-cab:before {
    width: 20px;
    height: 15px;
    top: -15px;
    right: 0;
    border-radius: 100% 0 0 0;
}
.TruckLoader-cab:after {
    border-radius: 50%;
    width: 16px;
    height: 16px;
    background: #444;
    left: 5px;
    border: 2px solid #fff;
    background: #333;
    position: absolute;
    bottom: -10px;
}
.TruckLoader-smoke, .TruckLoader-smoke:after, .TruckLoader-smoke:before {
  position: absolute;
  content: '';
  display: block;
  width: 10px;
  height: 10px;
  right: -1px;
  bottom: -5px;
  border-radius: 50%;
  background: #333;
}
.TruckLoader-smoke {
    animation: smoke-1 2s infinite;
}
.TruckLoader-smoke:after {
    animation: smoke-2 3s infinite;
}
.TruckLoader-smoke:before {
    animation: smoke-3 4s infinite;
}
.TruckLoader + hr{margin-top: 9.6rem;}
.TruckLoader + hr + h3{text-align: center;}
@-webkit-keyframes put-put {
  0% {
    margin-top: 0px;
    height: 50px;
  }
  5% {
    margin-top: -2px;
    height: 52px;
  }
  20% {
    margin-top: -1px;
    height: 50px;
  }
  35% {
    margin-top: 1px;
    height: 49px;
  }
  40% {
    margin-top: -1px;
    height: 51px;
  }
  60% {
    margin-top: 1px;
    height: 49px;
  }
  75% {
    margin-top: 0px;
    height: 50px;
  }
  80% {
    margin-top: -4px;
    height: 52px;
  }
  100% {
    margin-top: 1px;
    height: 49px;
  }
}
@-webkit-keyframes smoke-1 {
  0% {
    opacity: 0;
  }
  15% {
    opacity: 0.9;
  }
  100% {
    right: -30px;
    bottom: 5px;
    width: 30px;
    height: 30px;
    opacity: 0;
  }
}
@-webkit-keyframes smoke-2 {
  0% {
    opacity: 0;
  }
  15% {
    opacity: 0.9;
  }
  100% {
    right: -60px;
    bottom: 8px;
    width: 25px;
    height: 25px;
    opacity: 0;
  }
}
@-webkit-keyframes smoke-3 {
  0% {
    opacity: 0;
  }
  15% {
    opacity: 0.9;
  }
  100% {
    right: -40px;
    bottom: 2px;
    width: 35px;
    height: 35px;
    opacity: 0;
  }
}
@-webkit-keyframes move-truck {
  0% {
    margin-left: 90%;
    opacity: 0;
  }
  10% {
    opacity: 1;
  }
  50% {
    margin-left: 45%;
  }
  90% {
    opacity: 1;
  }
  100% {
    margin-left: 0;
    opacity: 0;
  }
}

</style>
    <div class="row wrapper-sucursal">
  <div class="col-xs-12 col-md-5 col-lg-3 _no-padding sucursales-lista">
    <ul class="list-group sucursal-container">
        <!-- Here goes the Clients list -->
    </ul>
  </div>
  <div class="hidden-xs col-md-7 col-lg-9 map-container">
      <div id="map">
          <!--<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d425998.14892663143!2d-70.9100195384674!3d-33.472472762753654!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9662c5410425af2f%3A0x8475d53c400f0931!2sSantiago%2C+Santiago+Metropolitan+Region!5e0!3m2!1sen!2scl!4v1497271181471" frameborder="0" style="border:0"></iframe>-->
      </div>
      <div id="TruckLoader">
          <div class="TruckLoader">
              <div class="TruckLoader-cab"></div>
              <div class="TruckLoader-smoke"></div>
          </div>
          <hr />
          <h3>Cargando ruta...</h3>
      </div>
  </div>
</div>
@endsection
@section('script')
    <script src="https://maps.googleapis.com/maps/api/js?libraries=geometry,places&ext=.js&key=AIzaSyBzRvHQoE265Wfz6gRRrzfpfKxBuj6_dcg"></script>
    <script>
        var map;
        var infowindow = new google.maps.InfoWindow();
        var colors = ["rgba(120, 10, 80, 1)","rgba(250, 250, 25, 1)","rgba(0, 150, 255, 1)","rgba(0, 150, 25, 1)","rgba(250, 0, 0, 1)"];
        function bindInfoWindow(marker, map, infowindow, html) {
            marker.addListener('click', function() {
                infowindow.setContent(html);
                infowindow.open(map, this);
            });
        }

        function initMap(route,waypts_info,origins_info,origin) {
            var directionsService = new google.maps.DirectionsService;
            var directionsDisplay = new google.maps.DirectionsRenderer({
                suppressPolylines: true,
                infoWindow: infowindow
            });
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 6,
                center: {
                    lat: -33.447487,
                    lng: -70.673676
                }
            });
            var icon = {
                url: "http://icons.iconarchive.com/icons/paomedia/small-n-flat/1024/shop-icon.png", // url
                scaledSize: new google.maps.Size(40, 40), // scaled size
                origin: new google.maps.Point(0,0), // origin
                anchor: new google.maps.Point(30, 35) // anchor
            };
            var iconOrigin = {
                url: "http://icons.iconarchive.com/icons/awicons/vista-artistic/128/office-building-icon.png", // url
                scaledSize: new google.maps.Size(40, 40), // scaled size
                origin: new google.maps.Point(0,0), // origin
                anchor: new google.maps.Point(30, 35) // anchor
            };
            var vehicle='';
            for(var i in waypts_info){
                vehicle='<br><b>Vehiculo: </b>'+waypts_info[i]['vehicle'];
                var customMarker = new google.maps.Marker({
                    position: new google.maps.LatLng(waypts_info[i]['lat'],waypts_info[i]['lng']),
                    map: map,
                    title:waypts_info[i]['title'],
                    icon: icon
                });
                var infoContent="<b>Informacion:</b><br><b>Nombre:</b> " +waypts_info[i]['title']+'<br><b>LatLng:</b> '+ waypts_info[i]['lat']+', '+waypts_info[i]['lng']+'<br><b>Direccion:</b> '+waypts_info[i]['direccion']+' '+vehicle;
                bindInfoWindow(customMarker, map, infowindow, infoContent);
            }
            for(var i in origins_info){
                var customMarker = new google.maps.Marker({
                    position: new google.maps.LatLng(origins_info[i]['lat'],origins_info[i]['lng']),
                    map: map,
                    title:origins_info[i]['title'],
                    icon: iconOrigin
                });
                var infoContent="<b>Informacion:</b><br><b>Nombre:</b> " +origins_info[i]['title']+'<br><b>LatLng:</b> '+ origins_info[i]['lat']+', '+origins_info[i]['lng']+'<br><b>Direccion:</b> '+origins_info[i]['direccion'];
                bindInfoWindow(customMarker, map, infowindow, infoContent);
            }
            directionsDisplay.setMap(map);
            var trafficLayer = new google.maps.TrafficLayer();
            trafficLayer.setMap(map);
            var count=0;
            for(var i in route){
                for(var x in route[i]){
                    console.log(x);
                    console.log('==========');
                    var waypts=[],
                        destination=[];
                    for(var y in route[i][x][0]){
                        var lat=parseFloat(route[i][x][0][y]['lat']),
                            lng=parseFloat(route[i][x][0][y]['lng']);
                        if(y<route[i][x][0].length-1)
                            waypts.push({'location':lat+','+lng,'stopover':true});
                        else
                            destination={'lat':lat,'lng':lng};
                    }
                }
                console.log(waypts);
                console.log('******');
                console.log(destination);
                console.log('******');
                console.log('%c .'+'%c'+x, 'font-size:5rem;color: '+colors[count],'color:#000;background:#fff;');
                calculateAndDisplayRoute(waypts,origin,destination,directionsService, directionsDisplay,colors[count]);
                count++;
            }
        }

        function calculateAndDisplayRoute(waypoints,origin,destination,directionsService, directionsDisplay,color) {
            directionsService.route({
                origin: origin,
                destination: destination,
                waypoints:waypoints,
                optimizeWaypoints: true,
                travelMode: google.maps.TravelMode.DRIVING
            }, function(response, status) {
                if (status === google.maps.DirectionsStatus.OK) {
                    directionsDisplay.setOptions({
                        directions: response,
                    });
                    renderDirectionsPolylines(response, color);
                } else {
                    window.alert('Directions request failed due to ' + status);
                }
            });
            directionsDisplay = new google.maps.DirectionsRenderer({
                suppressMarkers: true
            });
        }

        var polylineOptions = {
            strokeColor: '#C83939',
            strokeOpacity: 1,
            strokeWeight: 4
        };

        var polylines = [];

        function renderDirectionsPolylines(response,color) {
            var bounds = new google.maps.LatLngBounds();
            for (var i = 0; i < polylines.length; i++) {
                polylines[i].setMap(null);
            }
            var legs = response.routes[0].legs;

            // Define the symbol, using one of the predefined paths ('CIRCLE')
            // supplied by the Google Maps JavaScript API.
            var lineSymbol = {
              path: 'M 40 20 L 80 20 L 100 40 L 100 140 L 20 140 L 20 40 Z',
                anchor: new google.maps.Point(60, 10),
                scale: 0.15,
                strokeColor: '#000000',
                strokeWeight: 1,
                fillColor: color,
                fillOpacity: 0.8,
            }
            // Create the polyline and add the symbol to it via the 'icons' property.
            var line = new google.maps.Polyline({
                path: google.maps.geometry.encoding.decodePath(response.routes[0].overview_polyline),
                icons: [{
                    icon: lineSymbol,
                    offset: '100%'
                }],
                strokeColor: color,
                map: map
            });

            animateCircle(line);

            for (i = 0; i < legs.length; i++) {
                var steps = legs[i].steps;
                for (j = 0; j < steps.length; j++) {
                    var nextSegment = steps[j].path;
                    var stepPolyline = new google.maps.Polyline(polylineOptions);
                    stepPolyline.setOptions({
                        strokeColor: color
                    })
                    for (k = 0; k < nextSegment.length; k++) {
                        stepPolyline.getPath().push(nextSegment[k]);
                        bounds.extend(nextSegment[k]);
                    }
                    polylines.push(stepPolyline);
                    stepPolyline.setMap(map);
                    // route click listeners, different one on each step
                    google.maps.event.addListener(stepPolyline, 'click', function(evt) {
                        infowindow.setContent("Ruta:<br>" + evt.latLng.toUrlValue(6));
                        infowindow.setPosition(evt.latLng);
                        infowindow.open(map);
                    })
                }
            }
            map.fitBounds(bounds);
        }

        // Use the DOM setInterval() function to change the offset of the symbol
          // at fixed intervals.
          function animateCircle(line) {
              var count = 0;
              window.setInterval(function() {
                count = (count + 1) % 200;
                var icons = line.get('icons');
                icons[0].offset = (count / 2) + '%';
                line.set('icons', icons);
            }, 95);
          }

        var get_info = function(){
            return $.ajax({
                type: 'GET',
                dataType: 'json',
                processData: false,
                contentType:  false,
                url: '/api/clientes'
            });
        }
        function getPlace(){
            var info=get_info(),
                waypts={},
                waypts_info=[],
                origins_info=[],
                origin,
                html;
            info.then(function(response){
                var c=0;
               /* for(var i in response){
                    var cod_fac=response[i]['factura']['codigo'],
                        nombre=response[i]['factura']['client']['nombre'],
                        direccion=response[i]['factura']['client']['direccion'],
                        vehicle=response[i]['factura']['vehicle'],
                        lat=response[i]['factura']['client']['lat'],
                        lng=response[i]['factura']['client']['lng'];

                        var n=Object.keys(response).length;
                        if(c==n-1){
                            destination={'lat':response[i]['factura']['client']['lat'],'lng':response[i]['factura']['client']['lng']};
                        }
                        else if(c<n-1)
                            waypts.push({'location':response[i]['factura']['client']['lat']+','+response[i]['factura']['client']['lng'],'stopover':true});
                    origin=response[i]['factura']['origen']['ltLng'];
                    origins_info.push({'lat':response[i]['factura']['origen']['ltLng']['lat'],'lng':response[i]['factura']['origen']['ltLng']['lng'],'title':response[i]['factura']['origen']['nombre'],'direccion':response[i]['factura']['origen']['direccion'],'type':'origin'}); // Origins
                    waypts_info.push({'lat':response[i]['factura']['client']['lat'],'lng':response[i]['factura']['client']['lng'],'vehicle':vehicle,'title':response[i]['factura']['client']['nombre']+' - '+String.fromCharCode('A'.charCodeAt() + (c-1)), 'direccion':response[i]['factura']['origen']['direccion'],'type':'waypoint' });

                        if(c<n){
                            html='<li class="list-group-item sucursal"><div class="media"><div class="media-body"><h4 class="mt-0">'+nombre+'</h4><ul class="list-group"><li class="list-group-item active"><i class="ion-ios-location"></i> Ubicacion</li><li class="list-group-item"><i class="ion-compass"></i> <b>Direccion:</b> '+direccion+'</li><li class="list-group-item"><i class="ion-compass"></i> <b>Lat:</b> '+lat+'</li><li class="list-group-item"><i class="ion-earth"></i> <b>Lng:</b> '+lng+'</li></ul><ul class="list-group"><li class="list-group-item active"><i class="ion-ios-location"></i> Datos Generales</li><li class="list-group-item"><i class="ion-compose"></i> <b>Factura Asignada:</b> '+cod_fac+'</li><li class="list-group-item"><i class="ion-model-s"></i><b>Vehiculo Asignado: </b> '+vehicle+'</li></ul></div></div></li>';
                            $('.sucursal-container').append(html);
                        }
                        c++;
                }
                var interval=setInterval(function() {
                    $("#TruckLoader").fadeOut("slow");
                    var interval2=setInterval(function() {
                        $("#truck-loader").delay(1000).css('display','none');
                        $('#map').fadeIn("slow");
                        initMap(waypts,waypts_info,origins_info,origin,destination);
                        clearInterval(interval);
                        clearInterval(interval2);
                    }, 1000);
                }, 2500);*/

                for(var i in response){
                    if(i<response.length-1){
                    var facturas=response[i]['documents'],
                        nombre=response[i]['nombre'], //Client name
                        direccion=response[i]['direccion'], //Client address
                        vehicle=response[i]['vehicle'],
                        lat=response[i]['lat'], //Client lat
                        lng=response[i]['lng'], //Client lng
                        cod_fac=[],
                        destination=[],
                        vehicle_arr=[];
                        var n=Object.keys(response).length;

                        for(var x in vehicle){
                            vehicle_arr.push(vehicle[x]['nombre']);
                        }

                        //if(c==n-1){
                            //destination.push({'lat':lat,'lng':lng});
                        //}
                        //else if(c<n-1)
                            //waypts.push({'location':lat+','+lng,'stopover':true});
                   // origin.push(response[i]['origen']['ltLng']);
                        origin=response[i]['origen']['ltLng'];
                    origins_info.push({'lat':response[i]['origen']['ltLng']['lat'],'lng':response[i]['origen']['ltLng']['lng'],'title':response[i]['origen']['nombre'],'direccion':response[i]['origen']['direccion'],'type':'origin'}); // Origins
                    waypts_info.push({'lat':lat,'lng':lng,'vehicle':vehicle_arr,'title':nombre+' - '+String.fromCharCode('A'.charCodeAt() + (c-1)), 'direccion':direccion,'type':'waypoint' });

                        if(c<n){
                            for(var i in facturas){
                                cod_fac.push(facturas[i]['codigo']);
                            }
                            html='<li class="list-group-item sucursal"><div class="media"><div class="media-body"><h4 class="mt-0">'+nombre+'</h4><ul class="list-group"><li class="list-group-item active"><i class="ion-ios-location"></i> Ubicacion</li><li class="list-group-item"><i class="ion-compass"></i> <b>Direccion:</b> '+direccion+'</li><li class="list-group-item"><i class="ion-compass"></i> <b>Lat:</b> '+lat+'</li><li class="list-group-item"><i class="ion-earth"></i> <b>Lng:</b> '+lng+'</li></ul><ul class="list-group"><li class="list-group-item active"><i class="ion-ios-location"></i> Datos Generales</li><li class="list-group-item"><i class="ion-compose"></i> <b>Factura Asignada:</b> '+cod_fac+'</li><li class="list-group-item"><i class="ion-model-s"></i><b>Vehiculo Asignado: </b> '+vehicle_arr+'</li></ul></div></div></li>';
                            $('.sucursal-container').append(html);
                        }
                    }else{
                        var route=response[i]['route'];
                    }
                        c++;
                }
                var interval=setInterval(function() {
                    $("#TruckLoader").fadeOut("slow");
                    var interval2=setInterval(function() {
                        $("#truck-loader").delay(1000).css('display','none');
                        $('#map').fadeIn("slow");
                        initMap(route,waypts_info,origins_info,origin);
                        clearInterval(interval);
                        clearInterval(interval2);
                    }, 1000);
                }, 2500);

            });
        }
       /* function getPlace(){
            var info=get_info(),
                waypts=[],
                waypts_info=[],
                origin,
                destination,
                html;

            info.then(function(response){
                var c=1;

                origin=response['origen']['ltLng'];
                for(var i in response){
                    var n=Object.keys(response).length;
                    if(c==n-1)
                        destination={'lat':response[i]['lat'],'lng':response[i]['lng']};
                    else if(c<n-1)
                        waypts.push({'location':response[i]['lat']+','+response[i]['lng'],'stopover':true});
                    if(c==n)
                        waypts_info.push({'lat':response['origen']['ltLng']['lat'],'lng':response['origen']['ltLng']['lng'],'title':response['origen']['nombre']});
                    else
                        waypts_info.push({'lat':response[i]['lat'],'lng':response[i]['lng'],'title':response[i]['nombre']+' - '+String.fromCharCode('A'.charCodeAt() + (c-1)) });
                    if(c<n){
                        html='<li class="list-group-item sucursal"><div class="media"><div class="media-body"><h5 class="mt-0">'+response[i]['nombre']+'</h5><ul class="list-group"><li class="list-group-item active"><i class="ion-ios-location"></i> Ubicacion</li><li class="list-group-item"><i class="ion-compass"></i> Direccion: '+response[i]['direccion']+'</li><li class="list-group-item"><i class="ion-compass"></i> Lat: '+response[i]['lat']+'</li><li class="list-group-item"><i class="ion-earth"></i> Lng: '+response[i]['lng']+'</li></ul><ul class="list-group"><li class="list-group-item active"><i class="ion-ios-location"></i> Datos Generales</li><li class="list-group-item"><i class="ion-model-s"></i> Distancia: 50km</li><li class="list-group-item"><i class="ion-ios-time"></i> Tiempo: 1h</li></ul></div></div></li>';
                        $('.sucursal-container').append(html);
                    }
                    c++;
                }
                initMap(waypts,waypts_info,origin,destination);
            });
        }*/

        $(document).ready(function(){
            getPlace();
        });
    </script>
@endsection
@endif
