<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {

    public function __construct(){

        parent::__construct();


    }

    public function index(){


        $this->load->view('home');

    }

    public function get_tweets_west(){

        $this->load->model('site_model');
        $latitude = '55.508330';
        $longitude = '-120.157088';
        $distance = '2000km';
        $this->site_model->get_tweets($latitude, $longitude, $distance);

    }

    public function get_tweets_central(){

        $this->load->model('site_model');
        $latitude = '51.759246';
        $longitude = '-91.328963';
        $distance = '3500km';
        $this->site_model->get_tweets($latitude, $longitude, $distance);

    }

    public function get_tweets_east(){

        $this->load->model('site_model');
        $latitude = '51.541116';
        $longitude = '-65.840683';
        $distance = '2000km';
        $this->site_model->get_tweets($latitude, $longitude, $distance);

    }

    public function get_instagram(){

        $this->load->model('site_model');
        $this->site_model->get_instagram();

    }

    // public function get_facebook(){

    //     $this->load->model('site_model');
    //     // $fb = $this->site_model->get_facebook();
    //     $this->load->view('get_facebook');

    // }

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