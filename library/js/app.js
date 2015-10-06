/*jslint browser: true */
/*global $, jQuery, alert, console, ComeTogether:true */

var console = console || { log: function() { 'use strict'; } };

window.ComeTogether = window.ComeTogether || {};

(function (s) {

    'use strict';

    s.App = function () {

        return {
            initialized: false,
            elements: {},
            settings: {
                debug: false,
                host_url: 'http://' + window.location.hostname + '/'
            },

            init: function () {


                if (this.settings.debug) { console.log('init()'); }

                if (this.initalized) { return false; }
                this.initialized = true;

                // dom elements
                this.elements.body =  $('body', 'html');
                this.elements.debug = $('#txtDebug', this.elements.body);

                // configure debug based on config file
                if (this.elements.debug.val()) {
                    this.settings.debug = true;
                    this.initDebug();
                }

                // initialize foundation
                $(document).foundation();

                // initialize map
                this.initMap();


            },

            initMap: function() {

                if(this.settings.debug){ console.log('initMap()'); };

                var map = L.map('map', 'leatherface416.njcm6oc3')
                .setView([52.514457, -99.546737], 4);
                L.mapbox.accessToken = 'pk.eyJ1IjoibGVhdGhlcmZhY2U0MTYiLCJhIjoiTExKRHJhNCJ9.MLHjfgI8qpA-xiFMBS686w';

                // Disable drag and zoom handlers.
                map.dragging.disable();
                map.touchZoom.disable();
                // map.doubleClickZoom.disable();
                map.scrollWheelZoom.disable();

                var baseLayer = L.tileLayer('http://a.tiles.mapbox.com/v3/leatherface416.njcm6oc3/{z}/{x}/{y}.png', {});

                $('.twitter-status').html('Loading twitter...');
                $('.instagram-status').html('Loading instagram...');

                // var map = L.map('map', 'leatherface416.njcm6oc3')
                // .setView([52.514457, -99.546737], 4);
                // baseLayer.addTo(map);

                // define twitter cluster layer markers
                var twitter_markers = L.markerClusterGroup({
                    showCoverageOnHover: false,
                    removeOutsideVisibleBounds: true,
                    singleMarkerMode: true,
                    iconCreateFunction: function (cluster) {
                        var twitter_markers = cluster.getAllChildMarkers();
                        var n = 0;
                        for (var i = 0; i < twitter_markers.length; i++) {
                            n += twitter_markers[i].number;
                        }
                        return L.divIcon({ html: cluster.getChildCount(), className: 'twitterClusterMarker', iconSize: L.point(60, 60) });
                        // return L.mapbox.marker.icon({ 'marker-symbol': cluster.getChildCount(), 'marker-color': '#422' });
                    }
                });

                // define instagram cluster layer markers
                var instagram_markers = L.markerClusterGroup({
                    showCoverageOnHover: false,
                    removeOutsideVisibleBounds: true,
                    singleMarkerMode: true,
                    iconCreateFunction: function (cluster) {
                        var instagram_markers = cluster.getAllChildMarkers();
                        var n = 0;
                        for (var i = 0; i < instagram_markers.length; i++) {
                            n += instagram_markers[i].number;
                        }
                        return L.divIcon({ html: cluster.getChildCount(), className: 'instagramClusterMarker', iconSize: L.point(60, 60) });
                        // return L.mapbox.marker.icon({ 'marker-symbol': cluster.getChildCount(), 'marker-color': '#422' });
                    }
                });

                // call the geojson for tweets
                $.getJSON("site/populate_map_tweets", function(data) {

                    // console.log('geojson', data);

                    var geojson = L.geoJson(data, {

                        onEachFeature: function (feature, layer) {

                        // use a custom marker
                        // layer.setIcon(L.mapbox.marker.icon({'marker-symbol': 'circle-stroked', 'marker-color': '59245f'}));

                        var $popupHTML = '<img src="' + layer.feature.properties.image + '" alt="' + layer.feature.properties.screen_name + '" class="image" />'
                                    + '<h1 class="screen_name"><a href="http://www.twitter.com/' + layer.feature.properties.screen_name + '" target="_blank">@' + layer.feature.properties.screen_name + '</a></h1>'
                                    + '<p>' + layer.feature.properties.tweet + '</p>';
                        layer.bindPopup($popupHTML);

                        }
                    });
                    twitter_markers.addLayer(geojson);


                    // // example of passing options
                    // var map = L.map('map', {maxZoom: 9}).fitBounds(twitter_markers.getBounds());
                    // // set the view outter boundries to the available twitter_markers
                    // var map = L.map('map').fitBounds(twitter_markers.getBounds());


                    // var map = L.map('map', 'leatherface416.njcm6oc3')
                    // .setView([52.514457, -99.546737], 4);
                    baseLayer.addTo(map);
                    twitter_markers.addTo(map);
                    $('.twitter-status').html('');

                });

                // call the geojson for tweets
                $.getJSON("site/populate_map_instagrams", function(data) {

                    // console.log('geojson', data);

                    var geojson = L.geoJson(data, {

                        onEachFeature: function (feature, layer) {

                        // use a custom marker
                        // layer.setIcon(L.mapbox.marker.icon({'marker-symbol': 'circle-stroked', 'marker-color': '59245f'}));

                        var $popupHTML = '<img src="' + layer.feature.properties.image + '" alt="' + layer.feature.properties.screen_name + '" class="image" />'
                                    + '<h1 class="screen_name"><a href="http://www.twitter.com/' + layer.feature.properties.screen_name + '" target="_blank">@' + layer.feature.properties.screen_name + '</a></h1>'
                                    + '<p>' + layer.feature.properties.tweet + '</p>';
                        layer.bindPopup($popupHTML);

                        }
                    });
                    instagram_markers.addLayer(geojson);


                    // // example of passing options
                    // var map = L.map('map', {maxZoom: 9}).fitBounds(instagram_markers.getBounds());
                    // // set the view outter boundries to the available instagram_markers
                    // var map = L.map('map').fitBounds(instagram_markers.getBounds());


                    // var map = L.map('map', 'leatherface416.njcm6oc3')
                    // .setView([52.514457, -99.546737], 4);
                    baseLayer.addTo(map);
                    instagram_markers.addTo(map);
                    $('.instagram-status').html('');

                });





























            },


            initDebug: function () {

                if (this.settings.debug) { console.log('initDebug()'); }

                $(this.elements.body).append('<div id="debug-message"></div>');
                $('#debug-message').append('<p class="small">small</p><p class="medium">medium</p><p class="large">large</p><p class="exlarge">extra large</p>');
                $(window).resize(function () {
                    $('#debug-message').empty();
                    $('#debug-message').append('<p class="small">small</p><p class="medium">medium</p><p class="large">large</p><p class="exlarge">extra large</p>');
                    $('#debug-message').append('<p>width: ' + window.innerWidth + '</p>');
                });

            }

        };

    };

}(ComeTogether));



$(document).ready(function() {
    'use strict';
    ComeTogether.App().init();
});




