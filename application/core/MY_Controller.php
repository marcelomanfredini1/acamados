<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Controller extends CI_Controller{
	public function __construct(){
		parent::__construct();
		error_reporting();
		$logado = $this->session->userdata('logado');
            if($logado != 1)
				redirect('login');
	}
}