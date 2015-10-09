<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1,user-scalable=no" />
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta property="og:title" content="#ComeTogether Map" />
    <meta property="og:site_name" content="#ComeTogether Map" />
    <meta property="og:url" content="http://cometogethermap.com" />
    <meta property="og:description" content="A collection of Instagram and Twitter content tagged with #cometogether. Only user's with location services activated will appear here, so please enable location services for Instagram and Twitter on your mobile devices." />
    <!--
    <link rel="apple-touch-icon" href="apple-touch-icon-57.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-72.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-114.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="apple-touch-icon-144.png" />
    <link rel="icon" href="library/images/favicon.ico">
    -->
    <title>#ComeTogether Map</title>
    <link href='https://api.mapbox.com/mapbox.js/v2.2.2/mapbox.css' rel='stylesheet' />
    <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/MarkerCluster.css' rel='stylesheet' />
    <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/MarkerCluster.Default.css' rel='stylesheet' />
    <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-zoomslider/v0.7.0/L.Control.Zoomslider.css' rel='stylesheet' />
    <link rel="stylesheet" href="library/css/app.css" />

  </head>

    <!--[if IE ]>
       <body class="ie">
    <![endif]-->
    <!--[if !IE]>-->
       <body>
    <!--<![endif]-->

    <header class="site-header row">
        <div class="small-12 medium-8 medium-offset-2 columns">
            <h1>#ComeTogether Map</h1>
            <p>A collection of Instagram and Twitter content tagged with #cometogether. Only user's with location services activated will appear here, so please enable location services for Instagram and Twitter on your mobile devices.</p>
            <!-- Go to www.addthis.com/dashboard to customize your tools -->
            <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-50085eb25dded89d" async="async"></script>
            <div class="addthis_sharing_toolbox"></div>
            <p class="twitter-status"></p>
            <p class="instagram-status"></p>
            <!-- <p class="minimize"><a href="#">minimize this header</a></p> -->

        </div>
    </header>

    <div id="map"></div>

    <footer class="site-footer row">
        <div class="small-12 medium-8 medium-offset-2 columns">
            <p><a href="mailto:catchdataste@cometogethermap.com">catchdataste@cometogethermap.com</a> | #cometogethermap</p>
        </div>
    </footer>


    <input type="hidden" id="txtDebug" name="txtDebug" value="false" />

    <script src="library/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="library/bower_components/foundation/js/foundation.min.js"></script>
    <script src='https://api.mapbox.com/mapbox.js/v2.2.2/mapbox.js'></script>
    <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/leaflet.markercluster.js'></script>
    <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-zoomslider/v0.7.0/L.Control.Zoomslider.js'></script>
    <script src="library/js/app.js"></script>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-68480188-1', 'auto');
        ga('send', 'pageview');
    </script>

test
</body>
</html>