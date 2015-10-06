<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site_model extends CI_Model{


    function populate_map_tweets(){

        $query = $this->db->get('tweets');

        if($query->num_rows()){
            // all good

            $geo_json = array();
            $total = 0;

            foreach($query->result() as $key => $value){

                // echo "<pre>";
                // var_dump($value);
                // echo "</pre>";

                $marker = array(
                    'type' => 'Feature',
                    'geometry' => array(
                                        'type' => 'Point',
                                        'coordinates' => array($value->geo_longitude, $value->geo_latitude)
                    ),
                    'properties' => array(
                        'image' => $value->user_profile_image_url,
                        'screen_name' => $value->user_screen_name,
                        'tweet' => $value->tweet_text,
                        'hashtags' => $value->tweet_hashtags
                    )
                );

                array_push($geo_json, $marker);

                $total++;

            }

            return $geo_json;

        }else{

            $result = array('success' => false, 'message' => $this->db->error());
            return $result;

        }

    }


    function populate_map_instagrams(){

        $query = $this->db->get('instagram');

        if($query->num_rows()){
            // all good

            $geo_json = array();
            $total = 0;

            foreach($query->result() as $key => $value){

                // echo "<pre>";
                // var_dump($value);
                // echo "</pre>";

                if(strpos($value->caption_text, 'jays') !== FALSE){

                    $marker = array(
                        'type' => 'Feature',
                        'geometry' => array(
                                            'type' => 'Point',
                                            'coordinates' => array($value->location_longitude, $value->location_latitude)
                        ),
                        'properties' => array(
                            'image' => $value->pic_standard_resolution,
                            'screen_name' => $value->user_username,
                            'tweet' => $value->caption_text,
                            'hashtags' => $value->tags
                        )
                    );

                    array_push($geo_json, $marker);

                    $total++;

                }

            }

            return $geo_json;

        }else{

            $result = array('success' => false, 'message' => $this->db->error());
            return $result;

        }

    }



    function get_tweets($latitude, $longitude, $distance){

        // load twitter library
        $settings = array(
            'oauth_access_token' => "48384543-mLPyQLMX5xNwv3bwWC4l3eG7I623dofZJgGFbQL1T",
            'oauth_access_token_secret' => "5qsY1WU8iufKYQkaaCHDRGvbsNaR7mxeEniWCB84tZDg9",
            'consumer_key' => "6eQOA1iexKYtkKSYnLSm9vJyj",
            'consumer_secret' => "cyGAvdIAhg24nF4SiPZn3dN5YveMBd9Ma4q8R83zSNK6xkqfsQ"
        );
        $this->load->library('TwitterAPIExchange', $settings);

        // hashtags to search
        $hashtags = '#cometogether OR #gojaysgo OR #gojays OR #bluejays OR #jayswin OR #stiritup OR #blueoctober OR #timandsid OR #sn OR #aleastchamps';
        // $hashtags = '#cometogether OR #bluejays';

        // api info
        $url = 'https://api.twitter.com/1.1/search/tweets.json';
        $requestMethod = 'GET';

        // twitter will return a max of 100 results
        // if there are more than 100 results available, we will reload this page
        // and pass the max_id value provided to get the next page
        if(isset($_GET['reload']) && $_GET['reload'] === 'true'){

            $query = $this->db->get_where('config', array('var' => 'central_max_id'));
            $row = $query->row();

            // echo "<pre>";
            // var_dump($row->val);
            // echo "</pre>";

            $getfield = '?max_id=' . $row->val . 'q=' . urlencode($hashtags) . '&count=100&result_type=mixed&lang=en&geocode=' . $latitude . ',' . $longitude . ',' . $distance;


        }else{
            // first run
            $getfield = '?q=' . urlencode($hashtags) . '&count=100&result_type=mixed&lang=en&geocode=' . $latitude . ',' . $longitude . ',' . $distance;
        }

        // Perform the request
        $twitter = new TwitterAPIExchange($settings);
        $result = $twitter->setGetfield($getfield)
                     ->buildOauth($url, $requestMethod)
                     ->performRequest();

        // convert json object to php object
        $result_obj = json_decode($result);
        // echo "<pre>";
        // var_dump($result_obj);
        // echo "</pre>";

        // counter
        $total = 0;

        // // debug output
        // echo '<br>Results Found: ' . count($result_obj->statuses) . '<br>';
        // if(isset($result_obj->search_metadata->next_results)){
        //     echo '<br>Next Results: ' . $result_obj->search_metadata->next_results . '<br>';
        // }

        // save next results url to database so we can pull it on reload
        if(isset($result_obj->search_metadata->next_results)){

            // extract max_id from next_results string
            $parsed = parse_url($result_obj->search_metadata->next_results, PHP_URL_QUERY);
            parse_str($parsed, $params);

            $data = array('val' => $params['max_id']);
            $this->db->set($data);
            $this->db->where('var', 'central_max_id');

            if($this->db->update('config') === TRUE){
                // echo '<br>max_id Save to Database Successfully: ' . $this->db->affected_rows() . '<br>';
            }else{
                echo '<br>Error: ' . $this->db->error() . '<br>';
            }

        }else{

            // reset the config value to null
            $data = array('val' => NULL);
            $this->db->set($data);
            $this->db->where('var', 'central_max_id');
            $this->db->update('config');

        }

        // loop each tweet
        foreach($result_obj->statuses as $key => $value){

            // gather hashtags and store as a string
            $hashtags_arr = array();
            $hashtags_str = '';
            foreach($value->entities->hashtags as $hashtag){
                array_push($hashtags_arr, '#' . $hashtag->text);

            }
            $hashtags_str = implode(', ', $hashtags_arr);

            // // output data
            // echo '<br>user_profile_image_url: ' . $value->user->profile_image_url;
            // echo '<br>user_screen_name: ' . $value->user->screen_name;
            // echo '<br>user_full_name: ' . $value->user->name;
            // echo '<br>user_id: ' . $value->user->id;
            // echo '<br>user_location: ' . $value->user->location;
            // echo '<br>geo_latitude: ' . $value->geo->coordinates[0];
            // echo '<br>geo_longitude: ' . $value->geo->coordinates[1];
            // echo '<br>place_name: ' . $value->place->name;
            // echo '<br>place_full_name: ' . $value->place->full_name;
            // echo '<br>place_country: ' . $value->place->country;
            // echo '<br>tweet_id: ' . $value->id;
            // echo '<br>tweet_text: ' . $value->text;
            // echo '<br>hashtags: ' . $hashtags_str;
            // echo '<br>tweet_date: ' . $value->created_at;
            // echo '<br>date_added: ' . date('Y-m-d H:i:s');
            // echo '<br>---------------------------------------- ';

            // make sure the tweet hasn't already been added to db
            // $sql = "SELECT * FROM tweets WHERE tweet_id = '" . $value->id . "'";
            // $result = $conn->query($sql);
            $query = $this->db->get_where('tweets', array('tweet_id' => $value->id));

            if($query->num_rows() <= 0){
                // no existing records

                $data = array(
                    'user_screen_name'          => $this->db->escape_str($value->user->screen_name),
                    'user_full_name'            => $this->db->escape_str($value->user->name),
                    'user_profile_image_url'    => $this->db->escape_str($value->user->profile_image_url),
                    'user_id'                   => $this->db->escape_str($value->user->id),
                    'user_location'             => $this->db->escape_str($value->user->location),
                    'geo_latitude'              => $this->db->escape_str($value->geo->coordinates[0]),
                    'geo_longitude'             => $this->db->escape_str($value->geo->coordinates[1]),
                    'place_name'                => $this->db->escape_str($value->place->name),
                    'place_full_name'           => $this->db->escape_str($value->place->full_name),
                    'place_country'             => $this->db->escape_str($value->place->country),
                    'tweet_id'                  => $value->id_str,
                    'tweet_text'                => $this->db->escape_str($value->text),
                    'tweet_hashtags'            => $hashtags_str,
                    'tweet_date'                => $this->db->escape_str($value->created_at),
                    'date_added'                => date('Y-m-d H:i:s')
                );

                if($this->db->insert('tweets', $data)){
                    // echo " | Success: " . $this->db->affected_rows() . '<br>';
                    $total++;
                }else{
                    echo " | Error: " . $this->db->error() . '<br>';
                }
            }

        } // foreach($result_obj->statuses as $key => $value){


        if(isset($result_obj->search_metadata->next_results)){
            // echo '<br>reload it ' . $_SERVER['HTTP_HOST'];
            // echo '<br>' . $_SERVER['PHP_SELF'] . $result_obj->search_metadata->next_results;
            header('Refresh:0, url=http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '?&reload=true');
        }else{
            echo "\n" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ' has been executed.';
            echo "\n\nResults Found: " . count($result_obj->statuses);
            echo "\nTotal Inserted: " . $total;
        }

        return $result_obj;

    }


    function get_instagram(){

        $this->config->load('instagram_api', TRUE);
        $client_id = $this->config->item('instagram_client_id', 'instagram_api');

        $hashtag = 'cometogether';
        $query = array(
            'client_id' => $client_id,
            'count' => '33'
        );

        // instagram will return a max of 33 results
        // if there are more than 33 results available, we will reload this page
        // and pass the next_url value provided by the api to get the next page
        if(isset($_GET['reload']) && $_GET['reload'] === 'true'){
            // it's a reload, get the next url from the database

            $query = $this->db->get_where('config', array('var' => 'instagram_next_url'));
            $row = $query->row();
            $url = $row->val;

            // echo "<pre>";
            // var_dump($row->val);
            // echo "</pre>";

        }else{
            // first run
            $url = 'https://api.instagram.com/v1/tags/' . $hashtag . '/media/recent?' . http_build_query($query);
        }

        try{

            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);

            //Data are stored in $data
            // $data = json_decode(curl_exec($curl_connection), true);
            $data = json_decode(curl_exec($curl_connection));
            curl_close($curl_connection);

            // dump all of it
            echo "<pre>";
            var_dump($data);
            echo "</pre>";

            // // dump a single instagram
            // echo "<pre>";
            // var_dump($data->data[0]);
            // echo "</pre>";

            $totalFound = 0;
            $totalInserted = 0;

            if(sizeof($data->data) > 0){
                // we have records

                // save next results url to database so we can pull it on reload
                if(isset($data->pagination->next_url)){

                    $next_url = array('val' => $data->pagination->next_url);
                    $this->db->set($next_url);
                    $this->db->where('var', 'instagram_next_url');

                    if($this->db->update('config') === TRUE){
                        // echo '<br>next_url Save to Database Successfully: ' . $this->db->affected_rows() . '<br>';
                    }else{
                        echo '<br>Error: ' . $this->db->error() . '<br>';
                    }

                }else{

                    // reset the config value to null
                    $data = array('val' => NULL);
                    $this->db->set($data);
                    $this->db->where('var', 'instagram_next_url');
                    $this->db->update('config');

                }

                foreach($data->data as $key => $value){
                    // loop each instagram

                    if(isset($value->location->latitude) && isset($value->location->longitude)){

                        // prepare tags for insert
                        $tags_arr = $value->tags;
                        $tags_str = implode(',', $tags_arr);

                        // prepare caption text
                        if(isset($value->caption->text) && $value->caption->text != ''){
                            $caption_text = $value->caption->text;
                        }else{
                            $caption_text = '';
                        }

                        // echo "<br><br>Username: " . $value->user->username;
                        // echo "<br>Full name: " . $value->user->full_name;
                        // echo "<br>Profile picture: " . $value->user->profile_picture;
                        // echo "<br>User ID: " . $value->user->id;
                        // echo "<br>Latitude: " . $value->location->latitude;
                        // echo "<br>Longitude: " . $value->location->longitude;
                        // echo "<br>Location: " . $value->location->name;
                        // echo "<br>Tags: " . $tags_str;
                        // echo "<br>Caption: " . $value->caption->text;
                        // echo "<br>Created time: " . date('Y-m-d H:i:s', $value->created_time);
                        // echo "<br>Link: " . $value->link;
                        // echo "<br>Instagram ID: " . $value->id;
                        // echo "<br>Date added: " . date('Y-m-d H:i:s');
                        // echo '<br>---------------------------------------------';

                        // make sure the tweet hasn't already been added to db
                        $query = $this->db->get_where('instagram', array('instagram_id' => $value->id));

                        if($query->num_rows() <= 0){

                            // make sure the caption_text has the string 'jays' in it
                            if(strpos($caption_text, 'jays') !== FALSE){

                                $insert_data = array(
                                    'user_username'             => $value->user->username,
                                    'user_full_name'            => $value->user->full_name,
                                    'user_profile_picture'      => $value->user->profile_picture,
                                    'user_id'                   => $value->user->id,
                                    'location_latitude'         => $value->location->latitude,
                                    'location_longitude'        => $value->location->longitude,
                                    'location_name'             => $value->location->name,
                                    'pic_low_resolution'        => $value->images->low_resolution->url,
                                    'pic_thumbnail'             => $value->images->thumbnail->url,
                                    'pic_standard_resolution'   => $value->images->standard_resolution->url,
                                    'tags'                      => $tags_str,
                                    'caption_text'              => $caption_text,
                                    'created_time'              => date('Y-m-d H:i:s', $value->created_time),
                                    'link'                      => $value->link,
                                    'instagram_id'              => $value->id,
                                    'date_added'                => date('Y-m-d H:i:s')
                                );

                                if($this->db->insert('instagram', $insert_data)){
                                    // echo ' | Success: ' . $this->db->affected_rows() . '<br>';
                                    $totalInserted++;
                                }else{
                                    echo ' | Error: ' . $this->db->error() . '<br>';
                                }

                            }

                        }



                    }

                    $totalFound++;

                }

                // echo '<br><br>Results Found: ' . $totalFound;
                // echo '<br>Total Inserted: ' . $totalInserted;

                if(isset($data->pagination->next_url) && $data->pagination->next_url != ''){

                    // echo '<br><br>we have a next url';
                    header('Refresh:0, url=/site/get_instagram?reload=true');

                }else{
                    echo '<br><br>' . __FILE__ . ' has been executed.';
                }

            }


        } catch(Exception $e){

            return $e->getMessage();

        }

    }



    // function get_facebook(){

    //     $this->load->library('facebook');

    //     $access_token = $this->facebook->getAccessToken();
    //     echo '<br>at: ' . $access_token;
    //     // $result = $this->facebook->setAccessToken($access_token);
    //     // echo "<pre>";
    //     // var_dump($result);
    //     // echo "</pre>";


    //     // $url = 'https://graph.facebook.com/oauth/access_token';
    //     // $token_params = array(
    //     //     "type" => "client_cred",
    //     //     "client_id" => '578196538998097',
    //     //     "client_secret" => 'dfcdafa3b517c08c736bf03cf6abb714'
    //     // );
    //     // $ch = curl_init();
    //     // curl_setopt($ch, CURLOPT_URL, $url);
    //     // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //     // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($token_params, null, '&'));
    //     // $ret = curl_exec($ch);
    //     // curl_close($ch);
    //     // echo str_replace('access_token=', '', $ret);


    //     // $data = $this->facebook->api('/search?q=cometogether&type=place&center=51.759246,-91.328963');
    //     // $data = $this->facebook->api('/search?q=cometogether&type=post');

    //     // echo "<pre>";
    //     // var_dump($data);
    //     // echo "</pre>";





    // }










}