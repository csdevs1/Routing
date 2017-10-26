<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <style type="text/css">
      html { height: 100% }
      body { height: 100%; margin: 0; padding: 0 }
      #map-canvas { height: 80%}
    </style>
      <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBzRvHQoE265Wfz6gRRrzfpfKxBuj6_dcg&sensor=false">
    </script>
    <script type="text/javascript">
      //Declaring global variables
      var totalDistance;
      var directionsDisplay;
      var directionsService = new google.maps.DirectionsService();
      var map;
      var origin; 
      var points;

      function calcDistance(origin,points){                                 //To calculate distance
        var matrixService = new google.maps.DistanceMatrixService();
        matrixService.getDistanceMatrix({
          origins: [origin],
          destinations: points,
          travelMode: google.maps.TravelMode.DRIVING,
          avoidHighways: false,
          avoidTolls: false
        },callback);  
      }
        
        var send_info = function(){
                return $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    processData: false,
                    contentType:  false,
                    url: 'http://127.0.0.1/routing/api.php'
                });
            }
            function getPlace(){
                var send=send_info();
                send.then(function(response){
                    /*points.push("Palace of La Moneda - Moneda, Santiago");
                    for(var i in response){
                        //console.log(response[i].address);
                        origins.push(response[i].address);
                        
                    }*/
                    console.log(response);
                    origin=response['origin'][0];
                    points=response['destination'];
                    $('#resume').append('<p>El origen mas optimo es: '+origin+'.</p><p><b>Destinos:</b>'+points[0]+'<br>'+points[1]+'</div><p><b>Distancia:</b> '+response['distance']+'</p><p><b>Tiempo de llegada:</b> '+response['duration']+'</p>');
                    calcDistance(origin,points);
                });
            }
        
      function callback(response,status) {
        if(status != google.maps.DistanceMatrixStatus.OK) {
          alert("Sorry, it was an error: " + status);
        }

        else
        {
          var routes = response.rows[0];
          var sortable = [];
          for(var i= routes.elements.length-1; i>=0; i--)
          {
            var routeLength = routes.elements[i].distance.value;
            sortable.push([points[i],routeLength]);
          }

          sortable.sort(function(a,b){
            return a[1]-b[1];
          });

          var waypoints = new Array();

          for(var j=0;j< sortable.length-1;j++)
          {
            console.log(sortable[j][0]);
            waypoints.push({
              location: sortable[j][0],
              stopover: true
            });
          }
          var start = origin;
          var end = sortable[sortable.length-1][0];
          calcRoute(start,end,waypoints);
        }
      }
      function initialize() {                 //To initialize google maps
        directionsDisplay = new google.maps.DirectionsRenderer();
        var mapOptions = {
          center: new google.maps.LatLng({lat: -33.4489, lng: -70.6693}), //Placing the center of map to Mellon Labs, Chennai
          zoom: 10,
          mapTypeId: google.maps.MapTypeId.ROADMAP,
          draggableCursor: "crosshair"
        }; 
        map = new google.maps.Map(document.getElementById("map-canvas"),
            mapOptions);
        directionsDisplay.setMap(map);
      }
      function calcRoute(start,end,waypoints) {   //To calculate shortest route
        var request = {
        origin: start,
        destination: end,
        waypoints: waypoints,
        optimizeWaypoints: true,
        travelMode: google.maps.TravelMode.DRIVING
        };
        directionsService.route(request, function(response, status) { 
        if (status == google.maps.DirectionsStatus.OK) {
          directionsDisplay.setDirections(response);
          var route = response.routes[0];
          totalDistance = 0;
          for ( var i=0;i<route.legs.length;i++)
          {
            totalDistance+=route.legs[i].distance.value;
          }
          $('#resume').append("Least total Distance for the given route is " +totalDistance/1000 + "km");
          }
        });
      }
      google.maps.event.addDomListener(window, 'load', initialize);  //To show map when website fully loaded
    </script>
  </head>
  <body>
    <div id="map-canvas"> </div>
    <input type="submit" onclick="getPlace();">
    <div id="resume"></div>
  </body>
</html>