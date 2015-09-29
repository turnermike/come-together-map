<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {

    public function __construct(){

        parent::__construct();

        // load the facebook library
        $fb = $this->load->library('facebook');
        // get the user
        $user = $this->facebook->getUser();

        // echo "<pre>";
        // var_dump($user);
        // echo "</pre>";

        if($user){
            $user_profile = $this->facebook->api('/me');
            $data = array(
                'fb_fullname' => $user_profile['name']
            );
            $this->session->set_userdata($data);
        }else{
            $user = NULL;
            $scope = array('user');
            $login_url = $this->facebook->getLoginUrl($scope);
            redirect($login_url);
        }

        // initialize language toggle
        $site_lang = $this->session->userdata('site_lang');
        if($site_lang){
            $this->lang->load('pages_lang', $site_lang);
        }else{
            $this->lang->load('pages_lang', 'english');
        }

    }

    public function index(){

        $data['copy'] = array(
            'home_h1' => $this->lang->line('home_h1'),
            'home_h2' => $this->lang->line('home_h2'),
            'home_p1' => $this->lang->line('home_p1')
        );

        // $scope = array('user');
        // $data['login_url'] = $this->facebook->getLoginUrl($scope);

        $this->load->view('home', $data);

    }




}