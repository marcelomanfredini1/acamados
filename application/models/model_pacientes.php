<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 */
class Model_Pacientes extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
	public function inserirPaciente($dados=NULL)
	{
		if($dados!=null){
			$this->db->insert('cad_pacientes',$dados);
			$this->session->set_flashdata('cadastrook','<div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert">x</button><p>Cadastro efetuado com sucesso</p></div>');
			redirect('pacientes/newPaciente');
		}
		
	}
	public function get_all(){
		return $this->db->get('pacientes');
	}
	public function get_all2(){
		return $this->db->get('cad_pacientes');
	}
	public function do_update($dados=NULL, $condicao=null){
		if($dados!=NULL && $condicao != null):
			$this->db->update('cad_pacientes',$dados,array(id_cad_pacientes=>$condicao));
			$this->session->set_flashdata('edicaook','Edição efetuada com sucesso');
			redirect("pacientes/editar/$condicao");
		endif;
	}
	public function do_delete($condicao =null)
	{
		if ($condicao != NULL) {
			$this->db->delete('cad_pacientes',$condicao);
			$this->session->set_flashdata('excluirok','Registro Deletado com sucesso');
			redirect('pacientes/colPaciente');
		}
	}

	public function paciente($id_cad_pacientes=NULL) {

		return $this->db->query('select id_cad_pacientes,nome_paciente paciente, nome_unidade unidade
		from cad_pacientes cp, unidade u
		where cp.id_unidade =  u.id_unidade and id_cad_pacientes ='.$id_cad_pacientes);

	}

	public function get_byid($id_cad_pacientes=NULL){
		if ($id_cad_pacientes != null) {
			$this->db->where('id_cad_pacientes',$id_cad_pacientes);
			$this->db->limit(1);
			return $this->db->get('cad_pacientes');
		}else{
			return FALSE;
		}
	}
}
