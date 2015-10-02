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

                L.mapbox.accessToken = 'pk.eyJ1IjoibGVhdGhlcmZhY2U0MTYiLCJhIjoiTExKRHJhNCJ9.MLHjfgI8qpA-xiFMBS686w';

                var baseLayer = L.tileLayer('http://a.tiles.mapbox.com/v3/leatherface416.njcm6oc3/{z}/{x}/{y}.png', {});

                // var map = L.map('map', 'leatherface416.njcm6oc3')
                // .setView([52.514457, -99.546737], 4);
                // baseLayer.addTo(map);

                // define the cluster layer
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
                        return L.divIcon({ html: cluster.getChildCount(), className: 'twitterClusterMarker', iconSize: L.point(60, 60) });
                        // return L.mapbox.marker.icon({ 'marker-symbol': cluster.getChildCount(), 'marker-color': '#422' });
                    }
                });

                // call the geojson
                $.getJSON("site/populate_map_tweets", function(data) {

                    // console.log('geojson', data);

                    var geojson = L.geoJson(data, {
                        onEachFeature: function (feature, layer) {
                        // use a custom marker
                        layer.setIcon(L.mapbox.marker.icon({'marker-symbol': 'circle-stroked', 'marker-color': '59245f'}));

                        // add a popup with a chart
                        // var $popupHTML = '<h1>' + layer.feature.properties.screen_name + '</h1>'
                        //             + '<p>' + layer.feature.properties.tweet + '</p>'
                        //             + '<p>' + layer.feature.properties.hashtags + '</p>'
                        //             + layer.feature.properties.image;

                        var $popupHTML = '<img src="' + layer.feature.properties.image + '" alt="' + layer.feature.properties.screen_name + '" class="image" />'
                                    + '<h1 class="screen_name"><a href="http://www.twitter.com/' + layer.feature.properties.screen_name + '" target="_blank">@' + layer.feature.properties.screen_name + '</a></h1>'
                                    + '<p>' + layer.feature.properties.tweet + '</p>';
                        layer.bindPopup($popupHTML);

                        }
                    });
                    markers.addLayer(geojson);

                    // construct the map
                    // // example of passing options
                    // var map = L.map('map', {maxZoom: 9}).fitBounds(markers.getBounds());
                    // // set the view outter boundries to the available markers
                    // var map = L.map('map').fitBounds(markers.getBounds());


                    var map = L.map('map', 'leatherface416.njcm6oc3')
                    .setView([52.514457, -99.546737], 4);
                    baseLayer.addTo(map);
                    markers.addTo(map);

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




