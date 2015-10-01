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
        $tweets = $this->site_model->get_tweets_west();

    }

    public function get_tweets_central(){

        $this->load->model('site_model');
        $tweets = $this->site_model->get_tweets_central();

    }

    public function get_tweets_east(){

        $this->load->model('site_model');
        $tweets = $this->site_model->get_tweets_east();

    }

    public function populate_map_tweets(){

        $this->load->model('site_model');
        $tweets = $this->site_model->populate_map_tweets();
        echo json_encode($tweets);

    }



}