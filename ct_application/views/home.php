<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1,user-scalable=no" />
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <!--
    <link rel="apple-touch-icon" href="apple-touch-icon-57.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-72.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-114.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="apple-touch-icon-144.png" />
    <link rel="icon" href="library/images/favicon.ico">
    -->
    <title>#ComeTogether Canada</title>
    <link href='https://api.mapbox.com/mapbox.js/v2.2.2/mapbox.css' rel='stylesheet' />
    <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/MarkerCluster.css' rel='stylesheet' />
    <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/MarkerCluster.Default.css' rel='stylesheet' />
    <link rel="stylesheet" href="library/css/app.css" />

  </head>

    <!--[if IE ]>
       <body class="ie">
    <![endif]-->
    <!--[if !IE]>-->
       <body>
    <!--<![endif]-->

    <header class="row">
        <div class="small-12 medium-8 medium-offset-2 columns">
            <h1>#ComeTogether Map</h1>
            <p>A collection of Instagram and Twitter content tagged with the #cometogether hashtag. Only user's with location services activated will appear here, so please enable location services for Instagram and Twitter on your mobile devices.</p>
            <p class="twitter-status"></p>
            <p class="instagram-status"></p>
        </div>
    </header>

    <div id="map"></div>

    <input type="hidden" id="txtDebug" name="txtDebug" value="true" />

    <script src="library/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="library/bower_components/foundation/js/foundation.min.js"></script>
    <script src='https://api.mapbox.com/mapbox.js/v2.2.2/mapbox.js'></script>
    <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/leaflet.markercluster.js'></script>
    <script src="library/js/app.js"></script>

</body>
</html>