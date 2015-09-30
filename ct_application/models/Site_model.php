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

        return 'return stuff herexxx';

    }

}