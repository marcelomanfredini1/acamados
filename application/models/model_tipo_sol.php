<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
//tipo_solicitacao
/**
 * 
 */
class Model_Tipo_Sol extends CI_Model {
	
	function __construct() {
		parent::__construct();		
	}
	public function get_all(){
		return $this->db->get('tipo_solicitacao');
	}
}
