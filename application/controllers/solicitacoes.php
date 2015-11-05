<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Solicitacoes extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	// função apaga um item da lista de insumos.
	public function editar_array()
	 {
		$array_insumos = $_SESSION['array_insumos'];
		$array_insumos_nop = $_SESSION['array_insumos_nop'];
		$id = $this->uri->segment(3);
		$solicitacao = $this->model_sol->getSolicitacoById($id)->row();
		$tipos = $this->getOptTipo($solicitacao->id_tipo_solicitacao);
		if ($id == '') {
			$array_insumos = array();
			$array_insumos_nop = array();
			$array_insumos = $_SESSION['array_insumos'];
			$array_insumos_nop = $_SESSION['array_insumos_nop'];
			$dados = array(
					'titulo' => 'Sistema de Acamados',
					//'tela' => 'sol/newSolicitacao',
					'tela' => 'sol/view_new_solicitacao',
					'ok' => $this->array_to_object(array()),
					'ubs' => $this->getOptUbs(),
					'pacientes' => $this->getPacientes(),
					'insumos' =>$this->getInsumos(),
					'quantidade' => $this->getOptQtd(),
					'tipos'=> $tipos
				);		
				$this->load->view('index',$dados);
		}else{
			unset ($array_insumos[$id]);
			unset ($array_insumos_nop[$id]);
			$array_insumos = array_values($array_insumos);
			$array_insumos_nop = array_values($array_insumos_nop);
			$_SESSION['array_insumos_nop'] = $array_insumos_nop;
			$_SESSION['array_insumos'] = $array_insumos;
			$dados = array(
					'titulo' => 'Sistema de Acamados',
//					'tela' => 'sol/newSolicitacao',
					'tela' => 'sol/view_new_solicitacao',
					'ok' => $this->array_to_object(array()),
					'ubs' => $this->getOptUbs(),
					'pacientes' => $this->getPacientes(),
					'insumos' =>$this->getInsumos(),
					'quantidade' => $this->getOptQtd(),
					'tipos'=> $tipos
				);		
				$this->load->view('index',$dados);
		}
	 }

	 // Responsável por altera o Status de um nsumo, liberando ou deixando em fila de espera /INICIO

		public function liberarInsumos($cod_sol = NULL) {

			if($this->model_sol->liberarInsumos($cod_sol)) {

				$this->session->set_flashdata('edicaook','Status do insumo alterado com Sucesso!.');
				redirect('solicitacoes/editar/'.$cod_sol,'refresh');
			
			} else {
				
				$this->session->set_flashdata('edicaook','Status do insumo não alterado');
				redirect('solicitacoes/editar/'.$cod_sol,'refresh');
			}

		}

	// Responsável por altera o Status de um nsumo, liberando ou deixando em fila de espera /FIM

		//-----------------------------\\

	// Deletar algum insumo solicitado /INICIO

		public function deletarInsumo() {

			$id_insumo = $this->uri->segment(3); 
			$id_solicitacao = $this->uri->segment(4);

			if($this->model_sol->deletarInsumo($id_insumo,$id_solicitacao)) {

				$this->session->set_flashdata('aviso','Insumo deletado com Sucesso!.');
				redirect('solicitacoes/editar/'.$id_solicitacao,'refresh');
			} else {

				$this->session->set_flashdata('aviso','Não foi possível deletar o insumo');
				redirect('solicitacoes/editar/'.$id_solicitacao,'refresh');
			}


		}

	// Deletar algum insumo solicitado /FIM

	// Deletar uma solicitação e todos insumos que foram solicitados por ela. /INICIO

		public function deletar() {

			$id_solicitacao = $this->uri->segment(3);

			if($this->model_sol->deletarSolicitacao($id_solicitacao)) {

			$this->session->set_flashdata('aviso','Solicitação deletada com sucesso, os insumos que foram
			 solicitados também foram deletados.');
			redirect('solicitacoes/colSolicitacao/','refresh');

			} else {

			$this->session->set_flashdata('aviso','Não foi possível deletar a solicitacao');
			redirect('solicitacoes/colSolicitacao/','refresh');

			}

		}

	// Deletar uma solicitação e todos insumos que foram solicitados por ela. /FIM

	public function getOptQtd($id_insumo = 0)
	{
		$insumos = $this->model_insumos->retorna_all();
		if ($id_insumo == 0) {	
			return '';
		}else{
			foreach($insumos -> result() as $linha) {
				if ($id_insumo == $linha->id_cad_insumos){
					$qtd = $linha->quantidade;
				}			
			}
			return $qtd;
		}
	}
	public function getOptQtd2($id_insumo = 0)
	{
		$insumos = $this->model_insumos->retorna_all();
		$qtd = array();
		if ($id_insumo == 0) {	
			return '';
		}else{
			foreach($insumos -> result() as $linha) {
				if ($id_insumo == $linha->id_cad_insumos){
					array_push($qtd,array("$id_insumo" => $linha->quantidade));
				}			
			}
			return $qtd;
		}
	}
	public function getOptTipo($tipo = 0)
	{
		$tipos = $this->model_sol->getTipos();
			$option = "<option value=''></option>";
		if ($tipo == 0) {	
			foreach($tipos -> result() as $linha) {
				$option .= "<option value='$linha->id_tipo_solicitacao'>$linha->nome</option>";
			}
			return $option;
		}else{
			foreach($tipos -> result() as $linha) {
				if ($tipo == $linha->id_tipo_solicitacao){
					$option .= "<option selected=\"selected\" value=$linha->id_tipo_solicitacao>$linha->nome</option>";
				}else{
					$option .= "<option value='$linha->id_tipo_solicitacao'>$linha->nome</option>"; 
				}			
			}
			return $option;
		}
	}
	public function getOptUbs($id_user = 0)
	{
		$ubs = $this->model_ubs->retorna_ubs();
			$option = "<option value=''></option>";
		if ($id_user == 0) {	
			foreach($ubs -> result() as $linha) {
				$option .= "<option value='$linha->id_unidade'>$linha->nome_unidade</option>";
			}
			return $option;
		}else{
			$user = $this->model_pacientes->get_byid($id_user)->row();
			foreach($ubs -> result() as $linha) {
				if ($user->id_unidade == $linha->id_unidade){
					$option .= "<option selected=\"selected\" value=$linha->id_unidade>$linha->nome_unidade</option>";
				}else{
					$option .= "<option value='$linha->id_unidade'>$linha->nome_unidade</option>"; 
				}			
			}
			return $option;
		}
	}
	public function getInsumos($id_insumo = 0)
	{
		$insumos = $this->model_insumos->get_all2();
		$option = "<option value=''></option>";
		if ($id_insumo == 0) {
			foreach($insumos -> result() as $linha) {
					$option .= "<option value='$linha->id_cad_insumos'>$linha->nome_insumo</option>";
			}
			return $option;
		}else{
			foreach($insumos -> result() as $linha) {
					if ($id_insumo == $linha->id_cad_insumos){
						$option .= "<option selected=\"selected\" value='$linha->id_cad_insumos'>$linha->nome_insumo</option>";
					}else{
						$option .= "<option value='$linha->id_cad_insumos'>$linha->nome_insumo</option>";
					}
				}
			return $option;
		}
	}
	
	public function getPacientes($id_user = 0)
	{
		$pacientes = $this->model_pacientes->get_all2();
		$option = "<option value=''></option>";
		if ($id_user == 0) {
			foreach($pacientes -> result() as $linha) {
				$option .= "<option value='$linha->id_cad_pacientes'>$linha->nome_paciente</option>";
			}
			return $option;
		}else{
			$user = $this->model_pacientes->get_byid($id_user)->row();
				
			foreach($pacientes -> result() as $linha) {
				if ($user->id_cad_pacientes == $linha->id_cad_pacientes){
					$option .= "<option selected=\"selected\" value=$linha->id_cad_pacientes>$linha->nome_paciente</option>";
				}else{
					$option .= "<option value='$linha->id_cad_pacientes'>$linha->nome_paciente</option>";
				}			
			}
			return $option;
		}
	}

	/*Provisório para cadastrar solicitações*/

		public function novasolicitacao() {

			$ubs = $this->model_ubs->retorna_ubs();
			$dados = array(
				'titulo' => 'Sistema de Acamados',
				'tela' => 'sol/novasolicitacao',
				'pacientes' => $this->model_pacientes->get_all()->result(),
				'ubs' => $ubs,

			);	

			$this->load->view('index',$dados);  

	}

		public function solicitar() {

			$datestring = "%d %m %Y - %h:%i %a"; /*Formato da data*/
			$time = now(); /*Pegando horario*/

			$idpaciente = array (

				'id_tipo_solicitacao_tipo_solicitacao' => 1,
				'status' => 'Fila de Espera',
				'id_cad_pacientes_cad_pacientes' => $this->uri->segment(3), 
				'data_solicitacao' => mdate($datestring, $time), /*Atribuir data e hora da solicitação*/
			);

			if ($this->model_sol->nsolicitacao($idpaciente)) {

			$this->session->set_userdata('aviso','Solicitação cadastrada com sucesso');
			$this->novasolicitacao();		 

		} else {

			$this->session->set_userdata('aviso','Solicitação inválida');
			$this->novasolicitacao();

			}

		}

	/*
	public function novasolicitacao() { old*

		$paciente = $this->model_sol->nspaciente();

			$dados = array(
				'titulo' => 'Sistema de Acamados',
				'tela' => 'sol/novasolicitacao',
				'paciente' => $paciente,

			);	

			$this->load->view('index',$dados);  

	} 

	public function nosolicitacao() {

		$datestring = "%d %m %Y - %h:%i %a"; Formato da data
		$time = now(); Pegando horario

		if(!empty($this->input->post('id'))) {

			$id = explode('#',$this->input->post('id')); /*unico modo que achei para inserir somente o id do usuário no banco, caso
			contrário o insert iria tentar inserir tudo que estava no dropmenu "UBS + NOME PACIENTE + ID", agora ele guarda UBS + NOME PACIENTE
			na posição 0 do vetor e somente o ID que vem depois do # na posição 1 

		if ($id[0] != 'SELECIONE') {

		$idpaciente = array (

				'id_tipo_solicitacao_tipo_solicitacao' => 1,
				'status' => 'Fila de Espera',
				'id_cad_pacientes_cad_pacientes' => $id[1], /*Passando a posição 1 do vetor para o insert
				'data_solicitacao' => mdate($datestring, $time), /*Atribuir data e hora da solicitação
			);

		if ($this->model_sol->nsolicitacao($idpaciente)) {

			$this->session->set_userdata('aviso','Solicitação cadastrada com sucesso');
			$this->novasolicitacao();		 

		} else {

			$this->session->set_userdata('aviso','Solicitação inválida');
			$this->novasolicitacao();

			}
		} else {
			$this->session->set_userdata('aviso','Selecione algum paciente');
			$this->novasolicitacao();
			}
		}
	} */

	//public function newSolicitacao()
	public function view_new_solicitacao() {

		$ubs = $this->model_ubs->retorna_ubs();
		$dados = array(
		'title' =>'Consulta de Pacientes',
		'tela' => 'sol/view_new_solicitacao',
		'pacientes' => $this->model_pacientes->get_all()->result(),
		'ubs' => $ubs,
		);
		$this->load->view('index',$dados);

	}

	public function solicitacao_insumos() {
			$paciente = $this->model_pacientes->paciente($this->uri->segment(3));
			$tipos = $this->model_sol->getTipos();
			$dados = array(
				'titulo' => 'Sistema de Acamados',
				'tela' => 'sol/solicitacao_insumos',
				'paciente' => $paciente,
				'tipos' => $tipos->result(),
				'insumos' =>$this->model_insumos->get_all()->result(),
				'qtd_insumos' =>$this->model_insumos->get_all2(),
				'quantidade' => $this->getOptQtd2(),
			);		
			$this->load->view('index',$dados);
		}

	//Armazenar a solicitação de insumo no banco de dados. 
	public function armazenar_Solicitacao(){

		print_r($_POST) ;

	}

	public function view_new_solicitacao2()
	{

		$datestring = "%d %m %Y - %h:%i %a";
		$time = time();
		if (empty($_SESSION['array_insumos'])){
			$array_insumos = array();
			$array_insumos_nop = array();
		}
		else{
			$array_insumos = $_SESSION['array_insumos'];
			$array_insumos_nop = $_SESSION['array_insumos_nop'];
		}
	// transforma um array em object
	//verifica se ja existe itens na lista de insumos
		$flag = $this->uri->segment(3);
		if ($flag == 5) {
			$id_user = $_POST['id_cad_pacientes_cad_pacientes'];
			$tipo = $_POST['id_tipo_solicitacao_tipo_solicitacao'];
			if (!empty($_POST['id_cad_insumos_cad_insumos'])) {
				$id_insumo = $_POST['id_cad_insumos_cad_insumos'];
				$this->session->set_flashdata('cadastrook',"<div class=\"alert alert-block alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button><p> Solicitação adicionada com sucesso </p></div>");
			}
			else{
				$id_insumo = NULL;
			}
		}
		else
		{
			$id_user = NULL;
			$tipo = NULL;
		}
		if ($flag == 6) {
			$id_insumo = $_POST['id_cad_insumos_cad_insumos'];
			if (!empty($_POST['id_cad_pacientes_cad_pacientes'])) {
				$id_user = $_POST['id_cad_pacientes_cad_pacientes'];				
				$tipo = $_POST['id_tipo_solicitacao_tipo_solicitacao'];
			}
			else{
				$id_user = NULL;
				$tipo = NULL;
			}
		}else{
			$id_insumo = NULL;
		}
		if ($flag == 8) {
			$dados = array(
				'titulo' => 'Sistema de Acamados',
				'tela' => 'sol/view_new_solicitacao',
				'ok' => $this->array_to_object($array_insumos),
				'ubs' => $this->getOptUbs($id_user),
				'tipos' => $this->getOptTipo($tipo),
				'pacientes' => $this->getPacientes($id_user),
				'insumos' => $this->getInsumos($id_insumo),
				'quantidade' => $this->getOptQtd($id_insumo),

			);		
			$this->load->view('index',$dados);
		}
		if ($flag == 9) {
			$this->form_validation->set_rules('id_cad_pacientes_cad_pacientes','Nome','trim|required');
			$this->form_validation->set_rules('id_tipo_solicitacao_tipo_solicitacao','Tipo','trim|required');
			$this->form_validation->set_rules('status','Status','trim|required');
			if (!empty($_SESSION['array_insumos_nop'])) {
				if($this->form_validation->run()==TRUE){
					$dados = array(		
						'id_cad_pacientes_cad_pacientes' 		=> $this->input->post('id_cad_pacientes_cad_pacientes'),
						'id_tipo_solicitacao_tipo_solicitacao' 	=> $this->input->post('id_tipo_solicitacao_tipo_solicitacao'),
						'status' 								=> $this->input->post('status'),
						'data_solicitacao' => mdate($datestring, $time)
						);
					$this->session->set_flashdata('cadastrook',"<div class=\"alert alert-block alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button><p> Solicitação adicionada com sucesso </p></div>");
					$this->model_sol->inserir($dados,$_SESSION['array_insumos_nop']);
				} else {

					$this->session->set_flashdata('cadastrook',"<div class=\"alert alert-block alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button><p> Erro ao criar a solicitação </p></div>");

				}	
			}
		}
		if ($flag == 7)
			{
				/* Esta função -> form_validation    */		
				$this->form_validation->set_rules('id_cad_insumos_cad_insumos','Insumo','trim|required|numeric');
				$this->form_validation->set_rules('quantidade','Quantidade','trim|required|');
				$this->form_validation->set_rules('observacao','Observação','trim|required|');

				if($this->form_validation->run() == TRUE)
				{
					$id_cad_insumos_cad_insumos = $_POST['id_cad_insumos_cad_insumos'];					
					$adcionar = $this->ceckunico($id_cad_insumos_cad_insumos,$this->array_to_object($array_insumos));
					$qtd = $_POST['quantidade'];
					$observacao = $_POST['observacao'];
					$i= count($array_insumos);
					$operacoes = '<a href="'.base_url().'solicitacoes/editar_array/'.$i.'" class="label label-danger">Remover</a>';
					//cria um array para gerar a tabela, com o botão de operções que foi definido acima;
					$insumo_nome = $this->model_insumos->get_byid($id_cad_insumos_cad_insumos)->row();
					$atual = array(
									'id_cad_insumos_cad_insumos'=> $id_cad_insumos_cad_insumos,
									'nome' 						=> $insumo_nome->nome_insumo,
									'quantidade' 				=> $qtd, 
									'observacao' 				=> $observacao,
									'operacoes' 				=> $operacoes
									);
					//adciona no final do array;
					if ($adcionar == 1) {
						array_push($array_insumos,$atual);	
						// converte para object para poder gera a tabela
						//$table_insumos = ;
						// salva o array no _SESSION
					//$_SESSION['array_insumos'] = $array_insumos;
						//cria um array sem as operações(excluir) para enviar para o banco;
						$atual_nop = array('id_cad_insumos_cad_insumos' => $id_cad_insumos_cad_insumos, 
										   'quantidade' => $qtd, 
										   'observacao' => $observacao);
						array_push($array_insumos_nop,$atual);
					//$_SESSION['array_insumos_nop'] = $array_insumos_nop;
					}
					if ($adcionar == 0) {
						
						$this->session->set_flashdata('errodup','<div class="alert alert-block alert-danger"><button type="button" class="close" data-dismiss="alert">x</button><p>Você não pode colocar duas vezes o mesmo insumo</p></div>');
						//<div class="alert alert-block alert-danger"><button type="button" class="close" data-dismiss="alert">x</button><p>Você não pode colocar duas vezes o mesmo insumo</p></div>
					
					}
				}
				/*$dados = array(
				'titulo' => 'Sistema de Acamados',
				'tela' => 'sol/view_new_solicitacao',
				'ok' => $this->array_to_object($array_insumos),
				'ubs' => $this->getOptUbs($id_user),
				'tipos' => $this->getOptTipo($tipo),
				'pacientes' => $this->getPacientes($id_user),
				'insumos' =>$this->getInsumos($id_insumo),
				'quantidade' => $this->getOptQtd($id_insumo),
				);		
				$this->load->view('index',$dados);	*/
			}
			else
			{
				$dados = array(
					'titulo' => 'Sistema de Acamados',
					'tela' => 'sol/view_new_solicitacao',
					'ok' => $this->array_to_object($array_insumos),
					'ubs' => $this->getOptUbs($id_user),
					'tipos' => $this->getOptTipo($tipo),
					'pacientes' => $this->getPacientes($id_user),
					'insumos' =>$this->getInsumos($id_insumo),
					'quantidade' => $this->getOptQtd($id_insumo),
				);		
				$this->load->view('index',$dados);
			}
	}
	
	public function avSolicitacao()
	{
		$solicitacoes = $this->model_sol->getSolicitacoes()->result();
		$dados = array(
				'titulo' => 'Sistema de Acamados',
				'tela' => 'sol/avaliacao',
				'solicitacoes' => $solicitacoes,
		);
		$this->load->view('index',$dados);
	}
	public function avaliar()
	{
		$flag = $this->uri->segment(4);
		if ($flag == 1) {
			if (!empty($_POST['status'])) {
				if (!empty($_POST['observacao'])) {
					$dados = array(
						'status' => $_POST['status'],
						'observacao' => $_POST['observacao'],
					);
					$id = explode('-', $this->uri->segment(3));
					$this->model_sol->updateInsumoSol($dados,$id[0],$id[1]);
				}				
			}
		} else {
			$id_sol = $this->uri->segment(3);
			if ($id_sol == null) {
				redirect('solicitacoes/avSolicitacao');
			}
			$solicitacao = $this->model_sol->getSolicitacoById($id_sol)->row();
			$pacientes = $this->getPacientes($solicitacao->id_cad_pacientes_cad_pacientes);
			$ubs = $this->getOptUbs($solicitacao->id_cad_pacientes_cad_pacientes);
			$tipos = $this->getOptTipo($solicitacao->id_tipo_solicitacao);
			$dados = array(
				'titulo' => 'Sistema de Acamados',
				'tela' => 'sol/avaliar',
				'ubs' => $ubs,
				'pacientes' => $pacientes,
				'insumos' => $this->model_sol->getInsumos($id_sol)->result(),
				'tipos' => $tipos,
				'id'=> $id_sol,
				'sol'=> $solicitacao,
				'status' => $this->model_sol->getStatus($id_sol)->result(),
				'all_insumos' =>$this->getInsumos(),
				'qtd_insumos' =>$this->model_insumos->get_all2(),
				'quantidade' => $this->getOptQtd2(),
			);		
			$this->load->view('index',$dados);
		}
		
		
	}
	
	public function check_array($array)
	{
		if (empty($array)) {
			return FALSE;
		} else {
			return TRUE;			
		}
		
	}
	public function destroy()
	{
		session_destroy();
		$dados = array(
					'titulo' => 'Sistema de Acamados',
					'tela' => 'sol/view_new_solicitacao',
					'ok' => $this->array_to_object(array()),
					'ubs' => $this->getOptUbs(),
					'pacientes' => $this->getPacientes(),
					'tipos' => $this->getOptTipo(),
					'insumos' =>$this->getInsumos(),
					'quantidade' => $this->getOptQtd(),
				);		
				$this->load->view('index',$dados);
	}
	public function array_to_object($array=array()){
			return (object)$array;
	}
	public function salvar()
	{
		$this->form_validation->set_rules('id_cad_pacientes_cad_pacientes','Nome','trim|required');
		$this->form_validation->set_rules('id_unidade','UBS','trim|required');
		$this->form_validation->set_rules('id_tipo_solicitacao_tipo_solicitacao','Tipo','trim|required');
		$this->form_validation->set_rules('status','Status','trim|required');
		if (!empty($_SESSION['array_insumos_nop'])) {
			if($this->form_validation->run()==TRUE){
				$dados = elements(
					array(		
					'id_cad_pacientes_cad_pacientes',
					'id_unidade',
					'id_tipo_solicitacao_tipo_solicitacao',
					'status',
					),$this->input->post());
					$this->model_sol->inserir($dados,$_SESSION['array_insumos_nop']);
			}		
		}
	}
	public function colSolicitacao()//citacao() 
	{
		$solicitacoes = $this->model_sol->getSolicitacoes()->result();
		/*
		$ubs = $this->model_ubs->retorna_ubs();
		$pacientes = $this->model_pacientes->get_all2();
		$tipos = $this->model_sol->getTipos();
		$arrayTipos = array();
		$pac_ubs = array();
		$pac_nomes = array();
		unidade dos pacientes
		foreach ($pacientes as $linha) {
			foreach($ubs as $unidade) {
				if ($unidade->id_unidade == $linha->id_unidade){
					$pac_ubs["$linha->id_cad_pacientes"] = $unidade->nome_unidade;
				}
			}
		}
		//nome dos pacientes
		foreach ($solicitacoes as $linha) {
			foreach ($pacientes as $paciente) {
				if ($linha->id_cad_pacientes_cad_pacientes ==  $paciente->id_cad_pacientes) {
					$pac_nomes["$linha->id_cad_pacientes_cad_pacientes"] = $paciente->nome_paciente;
				}
			}
		}
		//tipos
		$tipos = $this->model_sol->getTipos();
		foreach ($tipos as $linha) {
			array_push($arrayTipos,array("$tipos->id_tipo_solicitacao" => $tipos->nome));
		}*/		
		$dados = array(									///aqui
				'titulo' => 'Sistema de Acamados',
				'tela' => 'sol/colSolicitacao',
				'solicitacoes' => $solicitacoes,
				);
		$this->load->view('index',$dados);
	}
	public function editar()
	{
		$this->form_validation->set_rules('id_cad_pacientes_cad_pacientes','Nome','trim|required');
		$this->form_validation->set_rules('id_tipo_solicitacao_tipo_solicitacao','Tipo','trim|required');
		if($this->form_validation->run()==TRUE){
			$dados = array(

				'id_tipo_solicitacao_tipo_solicitacao' => $this->input->post('id_tipo_solicitacao_tipo_solicitacao'),
				'id_cad_pacientes_cad_pacientes' => $this->input->post('id_cad_pacientes_cad_pacientes'),
				
				);
			if(!empty($this->uri->segment(3)))
			$this->model_sol->updateSol($dados,$this->uri->segment(3));	
		}

		$id_sol = $this->uri->segment(3);
		if ($id_sol == null) {
			redirect('solicitacoes/colSolicitacao');
		}
		$solicitacao = $this->model_sol->getSolicitacoById($id_sol)->row();
		$pacientes = $this->getPacientes($solicitacao->id_cad_pacientes_cad_pacientes);
		$ubs = $this->getOptUbs($solicitacao->id_cad_pacientes_cad_pacientes);
		$tipos = $this->getOptTipo($solicitacao->id_tipo_solicitacao);
		$dados = array(
			'titulo' => 'Sistema de Acamados',
			'tela' => 'sol/editSolicitacao',
			'ubs' => $ubs,
			'pacientes' => $pacientes,
			'insumos' => $this->model_sol->getInsumos($id_sol)->result(),
			'tipos' => $tipos,
			'id'=> $id_sol,
			'sol'=> $solicitacao,
			'status' => $this->model_sol->getStatus($id_sol)->result(),
			'all_insumos' =>$this->getInsumos(),
			'qtd_insumos' =>$this->model_insumos->get_all2(),
			'quantidade' => $this->getOptQtd2(),
		);		
		$this->load->view('index',$dados);
		
	}
	public function addInsumo()
	{
		$this->form_validation->set_rules('id_cad_insumos_cad_insumos','Insumo','trim|required');
		$this->form_validation->set_rules('observacao','Observação','trim|required');

		$datestring = "%d %m %Y - %h:%i %a";
			$time = time();
		
			if($this->form_validation->run()==TRUE){
				$dados = array(
					'id_cad_insumos_cad_insumos' => $_POST['id_cad_insumos_cad_insumos'],
					'quantidade' => $this->getOptQtd($_POST['id_cad_insumos_cad_insumos']),
					'observacao' => $_POST['observacao'],
					'id_sol_insumos_solicitacao_insumos' => $_POST['id_sol_insumos_solicitacao_insumos'],
					'data_sol_ins' =>  mdate($datestring, $time)
				);
				$insert = elements(array(
					'id_cad_insumos_cad_insumos',
					'quantidade',
					'observacao',
					'id_sol_insumos_solicitacao_insumos',
					'data_sol_ins'

				), $dados);

				// Verificar antes de inserir se não existe um cadastro.
				if($this->model_sol->validarInsert($_POST['id_cad_insumos_cad_insumos'],$_POST['id_sol_insumos_solicitacao_insumos'])) {

					$this->session->set_flashdata('adcOk',"<div class=\"alert alert-block alert-danger\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button><p>Não é permitido inserir o mesmo insumo mais de uma vez</p></div>");
					redirect("solicitacoes/editar/".$_POST['id_sol_insumos_solicitacao_insumos']."");

				} else if($this->model_sol->addInsumosWtId($insert,$_POST['id_sol_insumos_solicitacao_insumos']) == TRUE){
					
					$this->session->set_flashdata('adcOk',"<div class=\"alert alert-block alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button><p> Insumo adicionado com sucesso </p></div>");
					redirect("solicitacoes/editar/".$_POST['id_sol_insumos_solicitacao_insumos']."");
				} else {
					$this->session->set_flashdata('adcOk',"<div class=\"alert alert-block alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button><p> Error </p></div>");
					redirect("solicitacoes/editar/".$_POST['id_sol_insumos_solicitacao_insumos']."");
				}
			} else {
				$this->session->set_flashdata('adcOk',"<div class=\"alert alert-block alert-danger\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button><p> O insumo não foi adicionado, algum campo não foi preenchido </p></div>");
				redirect("solicitacoes/editar/".$_POST['id_sol_insumos_solicitacao_insumos']."");
			}

		
		}
	public function editarInsumo()
	{
		$ids = explode('-', $this->uri->segment(3));
		if (!empty($ids[1])) {
			$id_cad_insumos_cad_insumos = $ids[0];
			$id_sol_insumos_solicitacao_insumos = $ids[1];
			$obs = $this->input->post('observacao');
			$insumo = $this->model_sol->getInsumo($id_cad_insumos_cad_insumos,$id_sol_insumos_solicitacao_insumos)->row();

			if(!empty($obs)) {

				if(!$this->model_sol->updateInsumoSolicitado($id_sol_insumos_solicitacao_insumos,$id_cad_insumos_cad_insumos,$obs)){

					$this->session->set_flashdata('error','Erro ao atualizar!');
					redirect('solicitacoes/editarInsumo/'.$id_cad_insumos_cad_insumos.'-'.$id_sol_insumos_solicitacao_insumos,'refresh');

				} else {

					$this->session->set_flashdata('success','Atualizado com sucesso!');
					redirect('solicitacoes/editarInsumo/'.$id_cad_insumos_cad_insumos.'-'.$id_sol_insumos_solicitacao_insumos,'refresh');

				}

			}


			if (!empty($insumo)) {
				$dados = array(
						'titulo' => 'Sistema de Acamados',
						'tela' => 'sol/editItemInsumo',
						'id_cad_insumos_cad_insumos' => $id_cad_insumos_cad_insumos,
						'id_sol_insumos_solicitacao_insumos' =>$id_sol_insumos_solicitacao_insumos,
						'id_ref' =>$this->uri->segment(3),
						'insumo' => $insumo );
				$this->load->view('index',$dados);
			}
		}else{
			$this->session->set_flashdata('error','Explode error');
			$dados = array(
						'titulo' => 'Sistema de Acamados',
						'tela' => 'sol/editItemInsumo');
			$this->load->view('index',$dados);			
		}
	}
	public function ceckunico($atual='',$array_insumos ='')
	{
		$add = 1;
		foreach ($array_insumos as $insumos) {
			//if ($linha->id_cad_insumos_cad_insumos == $insumos->id_cad_insumos_cad_insumos) {
			if ($insumos['id_cad_insumos_cad_insumos'] == $atual) {
				$add = 0;
			}
		}
		return $add;
	}
}