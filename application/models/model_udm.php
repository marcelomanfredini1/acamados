<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 */
class Model_udm extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
		public function retorna_udms(){
			$consulta = $this->db->get("unidade_de_medida");
		return $consulta;	
	}
}
