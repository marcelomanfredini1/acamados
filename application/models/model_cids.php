<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 */
class Model_cids extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
		public function retorna_cids(){
			$consulta = $this->db->get("options_cids");
		return $consulta;	
	}
}