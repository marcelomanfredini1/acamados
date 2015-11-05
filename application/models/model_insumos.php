<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Model_insumos extends CI_Model{
	function __construct() {
		parent::__construct();
	}
	public function inserirInsumo($dados=null) {
		if($dados!=null){
			$this->db->insert('cad_insumos',$dados);
			$this->session->set_flashdata('cadastrook','<div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert">x</button><p>Cadastro efetuado com sucesso</p></div>');
			redirect('insumos/newInsumos');
		}
	}
	public function get_all(){
		return $this->db->get('insumos');
	}
	public function get_all2(){
		return $this->db->get('cad_insumos');
	}
	
	public function get_byid($id_cad_insumos=NULL){
		if ($id_cad_insumos != null) {
			$this->db->where('id_cad_insumos',$id_cad_insumos);
			$this->db->limit(1);
			return $this->db->get('cad_insumos');
		}else{
			return FALSE;
		}
	}
	
	public function do_update($dados=NULL, $condicao=null){
		if($dados!=NULL && $condicao != null):
			$this->db->update('cad_insumos',$dados,array(id_cad_insumos=>$condicao));
			$this->session->set_flashdata('edicaook','Edição efetuada com sucesso');
			redirect("insumos/editar/$condicao");
		endif;
	}
	
	public function do_delete($condicao =null)
	{
		if ($condicao != NULL) {
			$this->db->delete('cad_insumos',$condicao);
			$this->session->set_flashdata('excluirok','Registro Deletado com sucesso');
			redirect('insumos/colInsumos');
		}
	}
	public function retorna_all(){
		$consulta = $this->db->get("cad_insumos");
		return $consulta;
	}
}