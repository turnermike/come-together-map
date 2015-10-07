<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {

    public function __construct(){

        parent::__construct();


    }

    public function index(){


        $this->load->view('home');

    }

    public function get_tweets_north_west(){

        $this->load->model('site_model');
        $latitude = '55.508330';
        $longitude = '-120.157088';
        $distance = '2000km';
        $this->site_model->get_tweets($latitude, $longitude, $distance);

    }

    public function get_tweets_north_central(){

        $this->load->model('site_model');
        $latitude = '51.759246';
        $longitude = '-91.328963';
        $distance = '3500km';
        $this->site_model->get_tweets($latitude, $longitude, $distance);

    }

    public function get_tweets_north_east(){

        $this->load->model('site_model');
        $latitude = '51.541116';
        $longitude = '-65.840683';
        $distance = '2000km';
        $this->site_model->get_tweets($latitude, $longitude, $distance);

    }

    public function get_tweets_south_west(){

        $this->load->model('site_model');
        $latitude = '40.457695';
        $longitude = '-114.944543';
        $distance = '2000km';
        $this->site_model->get_tweets($latitude, $longitude, $distance);

    }

    public function get_tweets_south_central(){

        $this->load->model('site_model');
        $latitude = '40.757957';
        $longitude = '-100.178918';
        $distance = '3500km';
        $this->site_model->get_tweets($latitude, $longitude, $distance);

    }

    public function get_tweets_south_east(){

        $this->load->model('site_model');
        $latitude = '38.867819';
        $longitude = '-84.007045';
        $distance = '2000km';
        $this->site_model->get_tweets($latitude, $longitude, $distance);

    }

    public function set_instagram_cache(){

        $this->load->model('site_model');
        $this->site_model->set_instagram_cache();

    }

    // public function get_instagram_cache(){

    //     $this->load->model('site_model');
    //     $this->site_model->get_instagram_cache();

    // }

    public function get_instagram(){

        $this->load->model('site_model');
        $this->site_model->get_instagram();

    }

    public function populate_map_tweets(){

        $this->load->model('site_model');
        $tweets = $this->site_model->populate_map_tweets();
        echo json_encode($tweets);

    }

    public function populate_map_instagrams(){

        $this->load->model('site_model');
        $tweets = $this->site_model->populate_map_instagrams();
        echo json_encode($tweets);

    }


}