<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_Users extends CI_Model {
	public function get_usuario($nome,$senha) {
		$this->db->get('cad_user');
		$this->db->where('nome',$nome);
		$this->db->where('senha',$senha);
		$querylogin = $this->db->get('cad_user');
		return $querylogin->row(0);
	}

	public function login($options = array()) {
		$nome = $this->get_usuario($options['nome'],$options['senha']);
		if(!$nome) return false;
		return true;
	}

		public function alterarSenha($senha = null) /*Pensado para somente um usuário*/
	{
			$this->db->update('cad_user',$senha);
			return true;

	}
}
