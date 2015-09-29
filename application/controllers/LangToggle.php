<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class LangToggle extends CI_Controller{

    public function __construct(){

        parent::__construct();
        // $this->load->helper('url');

    }

    public function switch_language($language = ''){

        // default to english if no language set
        $language = ($language != '') ? $language : 'english';
        // save new language to session data
        $this->session->set_userdata('site_lang', $language);

        if(isset($_GET['returnUrl']) && $_GET['returnUrl'] !== ''){
            redirect($_GET['returnUrl']);
        }else{
            redirect(base_url());
        }

    }
}