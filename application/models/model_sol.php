<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 */
class Model_Sol extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
	public function inserir($dados=NULL,$insumos=NULL)
	{
		if($dados!=null){
			if($insumos!=null){
				$this->db->insert('solicitacao_insumos',$dados);
				if ($this->addInsumos($insumos)) {
					$this->session->set_flashdata('cadastrook',"<div class=\"alert alert-block alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button><p> Solicitação feita com sucesso </p></div>");
					redirect('solicitacoes/destroy');
				} else {
					$this->session->set_flashdata('cadastrook',"<div class=\"alert alert-block alert-alert\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button><p> $string </p></div>");
					redirect('solicitacoes/erro');
				}
						
			}
		}
	}
	public function addInsumos($dados =Null)
	{
		$query = $this->db->query('SELECT id_sol_insumos FROM solicitacao_insumos ORDER BY  id_sol_insumos DESC LIMIT 1');
		$id_sol_insumos = $query->row();
		foreach ($dados as $linha) {
				$id_sol_insumos_solicitacao_insumos = $id_sol_insumos->id_sol_insumos;
				$id_cad_insumos_cad_insumos = $linha['id_cad_insumos_cad_insumos'];
				$quantidade = $linha['quantidade'];
				$observacao = $linha['observacao'];
				$sql = "INSERT INTO insumos_solicitados (quantidade, 
														 id_cad_insumos_cad_insumos, 
														 id_sol_insumos_solicitacao_insumos,
														 observacao) 
					        VALUES (".$this->db->escape($quantidade).", 
					        		".$this->db->escape($id_cad_insumos_cad_insumos).", 
					        		".$this->db->escape($id_sol_insumos_solicitacao_insumos).", 
					        		".$this->db->escape($observacao).")";
										$this->db->query($sql);
		}
		if ($this->db->affected_rows() == 0) {
			return false;
		} else {
			return TRUE;
		}
	}
	public function getInsumos($id = NULL)
	{
		return $this->db->query("SELECT * FROM v_insumo_solicitados WHERE id_sol_insumos_solicitacao_insumos=".$this->db->escape($id));
	}
	public function getSolicitacoById($id = NULL)
	{		
		return $this->db->query("SELECT * FROM solicitacoes WHERE id=".$this->db->escape($id)." LIMIT 1");
	}
	public function getSolicitacoes()
	{
		return $this->db->get('solicitacoes');
	}
	public function getTipos(){
		return $this->db->get('tipo_solicitacao');
	}
	public function updateSol($dados=NULL, $condicao=null){

		if($dados!=NULL && $condicao != null):

			$this->db->where('id_sol_insumos',$condicao);
			$this->db->update('solicitacao_insumos',$dados);
			$this->session->set_flashdata('edicaook','Edição efetuada com sucesso');
			redirect("solicitacoes/editar/$condicao");
		
		endif;
	}
	public function updateInsumoSol($dados=NULL, $condicao0=null,$condicao1=null){

		if($dados!=NULL && $condicao0 != null && $condicao1 != null):
			$this->db->where('id_cad_insumos_cad_insumos', $condicao0);
			$this->db->where('id_sol_insumos_solicitacao_insumos', $condicao1);
			$this->db->update('insumos_solicitados',$dados);
			$this->session->set_flashdata('edicaook','Avaliação efetuada com sucesso');
			redirect("solicitacoes/avaliar/$condicao1");
		
		endif;
	}


	/*public function updateInsumos($dados=NULL){
		if($dados!=NULL && $condicao != null && $idsol != null):
			foreach ($dados as $linha) {
				$id_sol_insumos_solicitacao_insumos = $linha['id_sol_insumos_solicitacao_insumos'];
				$id_cad_insumos_cad_insumos = $linha['id_cad_insumos_cad_insumos'];
				$quantidade = $linha['quantidade'];
				$observacao = $linha['observacao'];
				$sql = "UPDATE insumos_solicitados SET quantidade=".$this->db->escape($quantidade).", observacao=".$this->db->escape($observacao)."
				WHERE id_cad_insumos_cad_insumos=".$this->db->escape($id_cad_insumos_cad_insumos)."
				AND id_sol_insumos_solicitacao_insumos=".$this->db->escape($id_sol_insumos_solicitacao_insumos).";";
				$this->db->query($sql);
			}
			$this->db->update('solicitacao_insumos',$dados,array(id_cad_insumos_cad_insumos=>$condicao,id_sol_insumos_solicitacao_insumos=>$idsol));
		endif;
		if ($this->db->affected_rows() == 0) {
			return false;
		} else {
			return TRUE;
		}
	} */

	//tráz para o select os pacientes e sua respectiva UBS, para abrir uma nova solicitação de forma provisória /INICIO.

	public function nspaciente() {

		return $this->db->query('SELECT nome_unidade, nome_paciente, id_cad_pacientes from cad_pacientes CP inner join unidade U
		on CP.id_unidade = U.id_unidade
		order by nome_unidade;')->result();

	}

	//tráz para o select os pacientes e sua respectiva UBS, para abrir uma nova solicitação de forma provisória /FIM.

	// grava a solicitação no banco PROVISÓRIO /INICIO.

		public function nsolicitacao($idpaciente = NULL) {

			return $this->db->insert('solicitacao_insumos',$idpaciente);

		}

	// grava a solicitação no banco PROVISÓRIO /FIM.

	public function addInsumosWtId($dados=NULL, $id_sol_insumos_solicitacao_insumos='')
	{
		if($id_sol_insumos_solicitacao_insumos != ''){
			if($dados!=null){
				return $this->db->insert('insumos_solicitados',$dados); 
			} 
		}
	}
	public function getInsumo($id_cad_insumos_cad_insumos ='', $id_sol_insumos_solicitacao_insumos='')
	{
		if ($id_cad_insumos_cad_insumos !='' && $id_sol_insumos_solicitacao_insumos !='') {
			return $this->db->query("SELECT *  FROM v_insumo_solicitados
			 WHERE id_cad_insumos_cad_insumos=".$this->db->escape($id_cad_insumos_cad_insumos)."  
			 AND id_sol_insumos_solicitacao_insumos=".$this->db->escape($id_sol_insumos_solicitacao_insumos)." LIMIT 1");
		}
	}

	// Verifica o Status atual da solicitação /INICIO.

		public function getStatus($id = NULL) {
			$this->db->where('id_sol_insumos',$id);
			return $this->db->get('solicitacao_insumos');
		}

	// Verifica o Status atual da solicitação /FIM.

		//=====================================\\

	// Função para alterar Status da solicitação /INICIO.

		public function liberarInsumos($cod_sol = NULL){

			$comparar = $this->getStatus($cod_sol)->result();
			$this->db->where('id_sol_insumos',$cod_sol);

			$datestring = "%d %m %Y - %h:%i %a";
			$time = time();


			if($comparar[0]->status == 'Liberado') {

				$dados = array(
					'status' => 'Fila de espera',
					'data_liberacao' => NULL
					);
				
				return $this->db->update('solicitacao_insumos',$dados);

			} else {

				$dados = array(
					'status' => 'Liberado',
					'data_liberacao' => mdate($datestring, $time)
					);

				return $this->db->update('solicitacao_insumos',$dados);

			}

		}

	// Função para alterar Status da solicitação /FIM.
		//=====================================\\

	// Função para deletar insumo no banco de dados /INICIO.

		public function deletarInsumo($id_insumo = NULL,$id_solicitacao = NULL) {

			$this->db->where('id_cad_insumos_cad_insumos',$id_insumo);
			$this->db->where('id_sol_insumos_solicitacao_insumos',$id_solicitacao);
			return $this->db->delete('insumos_solicitados');

		}

	// Função para deletar insumo no banco de dados /FIM.

	// Função para deletar uma solicitação e todos insumos que foram solicitados por ela. /INICIO

		public function deletarSolicitacao($id_solicitacao = NULL) {

			if($this->db->query('delete from insumos_solicitados where id_sol_insumos_solicitacao_insumos = '.$id_solicitacao.';')
				and $this->db->query('delete from solicitacao_insumos where id_sol_insumos = '.$id_solicitacao.';')) {

					return true;

				} else {
					return false;
				}

		}

	// Função para deletar uma solicitação e todos insumos que foram solicitados por ela. /Fim

	// Validar se já existe cadastro /INICIO.

		public function validarInsert($id_insumo = NULL, $id_solicitacao = NULL) {

			$this->db->where('id_cad_insumos_cad_insumos',$id_insumo);
			$this->db->where('id_sol_insumos_solicitacao_insumos',$id_solicitacao);

			if(!$this->db->get('insumos_solicitados')->result() == 0) {

				return true;
			} else {

				return false;
			}

		}

	// Validar se já existe cadastro /FIM.

	// Atualizar insumo solicitado /INICIO

		function updateInsumoSolicitado ($id_solicitacao = NULL, $id_insumo = NULL,$obs = '') {

			$dados = array ('observacao' => $obs );

			$this->db->where('id_cad_insumos_cad_insumos',$id_insumo);
			$this->db->where('id_sol_insumos_solicitacao_insumos',$id_solicitacao);
			if($this->db->update('insumos_solicitados',$dados)) {

				return true;

			} else {

				return false;

			}

		}

	// Atualizar insumo solicitado /FIM
}
