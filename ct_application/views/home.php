<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <link rel="icon" href="library/images/favicon.ico">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/library/images/win8-tile-icon.png">
    <title>Bluejays Hashtag Map</title>
    <link rel="stylesheet" href="library/css/app.css" />
    <script src='https://api.tiles.mapbox.com/mapbox.js/v1.6.3/mapbox.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox.js/v1.6.3/mapbox.css' rel='stylesheet' />

    <!-- <script src="library/bower_components/modernizr/modernizr.js"></script> -->
  </head>

    <!--[if IE ]>
       <body class="ie">
    <![endif]-->
    <!--[if !IE]>-->
       <body>
    <!--<![endif]-->

    <script src='//api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/leaflet.markercluster.js'></script>
    <link href='//api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/MarkerCluster.css' rel='stylesheet' />
    <link href='//api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/MarkerCluster.Default.css' rel='stylesheet' />







  <div id="map"></div>
  <script>
  // ADD YOUR BASE TILES
  // var baseLayer = L.tileLayer('http://a.tiles.mapbox.com/v3/landplanner.map-4y9ngu48/{z}/{x}/{y}.png', {
  //   maxZoom: 18
  // });
  var baseLayer = L.tileLayer('http://a.tiles.mapbox.com/v3/landplanner.map-4y9ngu48/{z}/{x}/{y}.png', {});



  // DEFINE THE CLUSTER LAYER
  var markers = L.markerClusterGroup({
    showCoverageOnHover: false,
    removeOutsideVisibleBounds: true,
    singleMarkerMode: true,
    iconCreateFunction: function (cluster) {
        var markers = cluster.getAllChildMarkers();
        var n = 0;
        for (var i = 0; i < markers.length; i++) {
            n += markers[i].number;
        }
        return L.divIcon({ html: cluster.getChildCount(), className: 'mycluster', iconSize: L.point(40, 40) });
    }
    // iconCreateFunction: function(cluster){
    //     return new L.DivIcon({ html: '<strong>' + cluster.getChildCount() + '</strong>' });
    // }
    });

  // CALL THE GEOJSON HERE
  $.getJSON("get_shoppers_locations.php", function(data) {
    var geojson = L.geoJson(data, {
      onEachFeature: function (feature, layer) {
        // USE A CUSTOM MARKER
        layer.setIcon(L.mapbox.marker.icon({'marker-symbol': 'circle-stroked', 'marker-color': '59245f'}));

        // ADD A POPUP WITH A CHART
        // layer.bindPopup("<h1>" + feature.properties.NAME + "</h1><h2><small>Population Change & Projection (in thousands)</small></h2><img width='265px' src='http://chart.googleapis.com/chart?chf=bg,s,67676700&chxl=0:|1950|1985|2020&chxp=0,10,50,90&chxr=0,0,105&chxs=0,676767,10.5,0,l,676767&chxt=x,y&chs=260x100&cht=ls&chco=0000FF&chds=a&chd=t:" + feature.properties.POP1950 + "," + feature.properties.POP1955 + "," + feature.properties.POP1960 + "," + feature.properties.POP1965 + "," + feature.properties.POP1970 + "," + feature.properties.POP1975 + "," + feature.properties.POP1980 + "," + feature.properties.POP1985 + "," + feature.properties.POP1990 + "," + feature.properties.POP1995 + "," + feature.properties.POP2000 + "," + feature.properties.POP2005 + "," + feature.properties.POP2010 + "," + feature.properties.POP2015 + "," + feature.properties.POP2020 +  "&chdlp=b&chg=-1,0&chls=3&chma=5,5,5,5|5'/>");

      }
    });
    markers.addLayer(geojson);

    // CONSTRUCT THE MAP
    // // example of passing options
    // var map = L.map('map', {maxZoom: 9}).fitBounds(markers.getBounds());
    // // set the view outter boundries to the available markers
    // var map = L.map('map').fitBounds(markers.getBounds());
    var map = L.map('map', 'mturner.e530636c')
    .setView([52.514457, -99.546737], 4);
    baseLayer.addTo(map);
    markers.addTo(map);
  });
  </script>



















    <footer class="row">
        <div class="large-12 columns">
            <p>Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
        </div>
    </footer>

    <input type="hidden" id="txtDebug" name="txtDebug" value="true" />

    <script src="library/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="library/bower_components/foundation/js/foundation.min.js"></script>
    <script src="library/js/app.js"></script>

  </body>
</html>