<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signin extends CI_Controller {
    public function Google()
    {
        $data = array();
        $this->load->helper('url');
        $this->load->view('Signin/Google');
    }
    
    public function Facebook()
    {
        $data = array();
        $this->load->helper('url');
        $this->load->view('Signin/Facebook');
    }
}
