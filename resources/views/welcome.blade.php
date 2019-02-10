<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <style media="screen">
            /* Always set the map height explicitly to define the size of the div
            * element that contains the map. */
            #map {
            height: 100%;
            }
            /* Optional: Makes the sample page fill the window. */
            html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            }
        </style>
        <script type="text/javascript">

            function initMap() {
              var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 13,
                center: {lat: 51.501904, lng: -0.115871}
              });

              var transitLayer = new google.maps.TransitLayer();
               transitLayer.setMap(map);
            }

        </script>

    </head>
    <body>

         <div id="map"></div>
        <!-- Replace the value of the key parameter with your own API key. -->
        <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAfdjXtvT1_D_4mOTkr17iU2uO0nH_FeWI&callback=initMap">
        </script>



    </body>
</html>
