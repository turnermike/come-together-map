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
                if (this.elements.debug.val() === 'true') {
                    this.settings.debug = true;
                    this.initDebug();
                }

                // initialize foundation
                $(document).foundation();

                // initialize map
                var map = this.initMap();

                // initialize header
                // this.initHeader(map);


            },

            initMap: function() {

                if(this.settings.debug){ console.log('initMap()'); };

                L.mapbox.accessToken = 'pk.eyJ1IjoibGVhdGhlcmZhY2U0MTYiLCJhIjoiTExKRHJhNCJ9.MLHjfgI8qpA-xiFMBS686w';

                if(Foundation.utils.is_medium_up()){
                    // it's medium up, center map over atlantic
                    var map = L.map('map', { zoomControl: false }).setView([22.316909, -39.956893], 3);
                }else{
                    // it's mobile, center map over canada
                    var map = L.map('map', { zoomControl: false }).setView([52.514457, -99.546737], 3);
                }
                this.settings.map_obj = map;


                // add leaflet zoom slider
                L.control.zoomslider().addTo(map);

                // Disable drag and zoom handlers.
                // map.dragging.disable();
                map.touchZoom.disable();
                // map.doubleClickZoom.disable();
                map.scrollWheelZoom.disable();

                // if is medium up, center the popup
                if(Foundation.utils.is_medium_up()){
                    // center popup on click
                    map.on('popupopen', function(e) {
                        var px = map.project(e.popup._latlng); // find the pixel location on the map where the popup anchor is
                        px.y -= (e.popup._container.clientHeight/2); // find the height of the popup container, divide by 2, subtract from the Y axis of marker location
                        map.panTo(map.unproject(px),{animate: true}); // pan to new center
                    });
                }



                var baseLayer = L.tileLayer('http://a.tiles.mapbox.com/v3/leatherface416.njcm6oc3/{z}/{x}/{y}.png', {});
                baseLayer.addTo(map)

                // set loading messages
                $('.twitter-status').html('<img src="library/images/ajax-loader.gif" alt="loading..." class="loader" /> Loading twitter...');
                $('.instagram-status').html('<img src="library/images/ajax-loader.gif" alt="loading..." class="loader" /> Loading instagram...');

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

                    // baseLayer.addTo(map);
                    twitter_markers.addTo(map);
                    // $('.twitter-status').html('');
                    $('.twitter-status').remove();

                });

                // call the geojson for tweets
                $.getJSON("site/populate_map_instagrams", function(data) {

                    // console.log('data', data);

                    if(data){
                        // we have info from the cache

                        var geojson = L.geoJson(data, {

                            onEachFeature: function (feature, layer) {

                            // use a custom marker
                            // layer.setIcon(L.mapbox.marker.icon({'marker-symbol': 'circle-stroked', 'marker-color': '59245f'}));

                            var $popupHTML = '<img src="' + layer.feature.properties.image + '" alt="' + layer.feature.properties.screen_name + '" class="image" />'
                                        + '<h1 class="screen_name"><a href="https://www.instagram.com/' + layer.feature.properties.screen_name + '" target="_blank">@' + layer.feature.properties.screen_name + '</a></h1>'
                                        + '<p>' + layer.feature.properties.tweet + '</p>';
                            layer.bindPopup($popupHTML);

                            }
                        });

                        instagram_markers.addLayer(geojson);
                        instagram_markers.addTo(map);
                        $('.instagram-status').remove();

                    }else{
                        // no cache data, reload because

                        location.reload();

                    }


                });

                return map;

            },


            initHeader: function (map) {

                if(this.settings.debug){ console.log('initHeader()'); };

                // var MAP = map;

                // $('.minimize a', 'header').on('click', function(e){

                //     e.preventDefault();

                //     $('.site-header').addClass('minimized');

                //     // set the map height
                //     // get the window height
                //     var window_height = $(window).height();
                //     var header_height = $('.site-header').height();
                //     var footer_height = $('.site-footer').height();

                //     var new_map_height = window_height - (header_height + footer_height);

                //     console.log('wh: ' + window_height);
                //     console.log('hh: ' + header_height);
                //     console.log('fh: ' + footer_height);
                //     console.log('new: ' + new_map_height);

                //     $('#map').height(new_map_height);

                //     window.setTimeout(function(MAP){
                //         MAP.updateSize();
                //     }, 1000);



                // })

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




