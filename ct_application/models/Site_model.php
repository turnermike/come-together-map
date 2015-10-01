<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site_model extends CI_Model{

    function get_tweets_central(){

        // load twitter library
        $settings = array(
            'oauth_access_token' => "48384543-mLPyQLMX5xNwv3bwWC4l3eG7I623dofZJgGFbQL1T",
            'oauth_access_token_secret' => "5qsY1WU8iufKYQkaaCHDRGvbsNaR7mxeEniWCB84tZDg9",
            'consumer_key' => "6eQOA1iexKYtkKSYnLSm9vJyj",
            'consumer_secret' => "cyGAvdIAhg24nF4SiPZn3dN5YveMBd9Ma4q8R83zSNK6xkqfsQ"
        );
        $this->load->library('TwitterAPIExchange', $settings);

        // hashtags to search
        $hashtags = '#mlb OR #gojaysgo OR #bluejays OR #jayswin OR #stiritup OR #gojays OR #cometogether';
        // $hashtags = '#gojaysgo OR #bluejays OR #jayswin OR #stiritup OR #gojays OR #cometogether';

        // api info
        $url = 'https://api.twitter.com/1.1/search/tweets.json';
        $requestMethod = 'GET';

        // twitter will return a max of 100 results
        // if there are more than 100 results available, we will reload this page
        // and pass the max_id value provided to get the next page
        if(isset($_GET['reload']) && $_GET['reload'] === 'true'){

            $sql = "SELECT val FROM config WHERE var = 'central_max_id'";
            $result = $conn->query($sql);
            $row = $result->fetch_row();
            // echo 'row: ' . $row[0];
            $getfield = '?max_id=' . $row[0] . 'q=' . $hashtags . '&count=100&result_type=mixed&lang=en&geocode=51.759246,-91.328963,2000km';


        }else{
            // first run
            $getfield = '?q=' . $hashtags . '&count=100&result_type=mixed&lang=en&geocode=51.759246,-91.328963,2000km';
        }

        // Perform the request
        $twitter = new TwitterAPIExchange($settings);
        $result = $twitter->setGetfield($getfield)
                     ->buildOauth($url, $requestMethod)
                     ->performRequest();

        // convert json object to php object
        $result_obj = json_decode($result);

        // counter
        $total = 0;

        // debug output
        echo '<br>Results Found: ' . count($result_obj->statuses) . '<br>';
        if(isset($result_obj->search_metadata->next_results)){
            echo '<br>Next Results: ' . $result_obj->search_metadata->next_results . '<br>';
        }

        // save next results url to database so we can pull it on reload
        if(isset($result_obj->search_metadata->next_results)){

            // extract max_id from next_results string
            $parsed = parse_url($result_obj->search_metadata->next_results, PHP_URL_QUERY);
            parse_str($parsed, $params);

            $data = array('val' => $params['max_id']);
            $this->db->set($data);
            $this->db->where('var', 'central_max_id');

            if($this->db->update('config') === TRUE){
                echo '<br>max_id Save to Database Successfully: ' . $this->db->affected_rows() . '<br>';
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

            // output data
            echo '<br>user_screen_name: ' . $value->user->screen_name;
            echo '<br>user_full_name: ' . $value->user->name;
            echo '<br>user_id: ' . $value->user->id;
            echo '<br>user_location: ' . $value->user->location;
            echo '<br>geo_latitude: ' . $value->geo->coordinates[0];
            echo '<br>geo_longitude: ' . $value->geo->coordinates[1];
            echo '<br>place_name: ' . $value->place->name;
            echo '<br>place_full_name: ' . $value->place->full_name;
            echo '<br>place_country: ' . $value->place->country;
            echo '<br>tweet_id: ' . $value->id;
            echo '<br>tweet_date: ' . $value->created_at;
            echo '<br>date_added: ' . date('Y-m-d H:i:s');
            echo '<br>---------------------------------------- ';

            // if country code is canada, insert it to the database
            if(strtoupper($value->place->country_code) === "CA"){

                // make sure the tweet hasn't already been added to db
                // $sql = "SELECT * FROM tweets WHERE tweet_id = '" . $value->id . "'";
                // $result = $conn->query($sql);
                $query = $this->db->get_where('tweets', array('tweet_id' => $value->id));



                if($query->num_rows() <= 0){
                    // no existing records

                    $data = array(
                        'user_screen_name'      => $this->db->escape_str($value->user->screen_name),
                        'user_full_name'      => $this->db->escape_str($value->user->name),
                        'user_id'      => $this->db->escape_str($value->user->id),
                        'user_location'      => $this->db->escape_str($value->user->location),
                        'geo_latitude'      => $this->db->escape_str($value->geo->coordinates[0]),
                        'geo_longitude'      => $this->db->escape_str($value->geo->coordinates[1]),
                        'place_name'      => $this->db->escape_str($value->place->name),
                        'place_full_name'      => $this->db->escape_str($value->place->full_name),
                        'place_country'      => $this->db->escape_str($value->place->country),
                        'tweet_id'      => $value->id_str,
                        'tweet_text'      => $this->db->escape_str($value->text),
                        'tweet_date'      => $this->db->escape_str($value->created_at),
                        'date_added'      => date('Y-m-d H:i:s')
                    );




                    // if($conn->query($sql) === TRUE){
                    //     echo " | Success: " . $conn->affected_rows . '<br>';
                    //     $total++;
                    // }else{
                    //     echo " | Error: " . $conn->error . '<br>';
                    // }
                }

            } // if($value->place->country_code === "CA"){


        }

        echo '<br>Total: ' . $total;






























        // echo "<pre>";
        // var_dump($result_obj);
        // echo "</pre>";

        return $result_obj;

    }

}