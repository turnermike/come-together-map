<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {

    public function __construct(){

        parent::__construct();


    }

    public function index(){


        $this->load->view('home');

    }

    public function get_tweets_central(){

        $this->load->model('site_model');
        $tweets = $this->site_model->get_tweets_central();

        echo "<pre>";
        var_dump($tweets);
        echo "</pre>";

    }




}