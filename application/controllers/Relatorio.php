<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Relatorio extends MY_Controller {
	
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
	
	public function geral() {

		$geral = $this->model_relatorios->trazerTodos()->result();

		$dados = array(
					'titulo' => 'Sistema de Acamados',
					'tela' => 'relatorios/todos',
					'query' => $geral
				);		

				$this->load->view('index',$dados);

		}
	
	public function unidade()
	{
		$id_sol = $this->uri->segment(3);
		if ($id_sol != null)
		{
			$solicitacao = $this->model_sol->getSolicitacoById($id_sol)->row();
			$pacientes = $this->getPacientes($solicitacao->id_cad_pacientes_cad_pacientes);
			$ubs = $this->getOptUbs($solicitacao->id_cad_pacientes_cad_pacientes);
			$tipos = $this->getOptTipo($solicitacao->id_tipo_solicitacao);
			$dados = array(
				'titulo' => 'Sistema de Acamados',
				'tela' => 'relatorios/insumos_solicitacao',
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
		else 
		{
			$ubs = $this->model_ubs->retorna_ubs();
			$option = "<option value=''></option>";
			foreach($ubs -> result() as $linha) {
				$option .= "<option value='$linha->id_unidade'>$linha->nome_unidade</option>"; 
			}
			if (!empty($_POST['id_unidade'])) {
				$result = $this->model_relatorios->solicitacoesUnidades($_POST['id_unidade'])->result();
			} else {
				redirect("relatorio/insporuni");
			}
			$dados = array(
				'titulo' => 'Sistema de Acamados',
				'tela' => 'relatorios/result_insumo_unidade',
			 	'options_ubs' => $option,
			 	'resultado' => $result,
			);
			$this->load->view('index',$dados);			
		}
	}

	public function insporuni(){ /*traz a quantidade de insumos solicitado por unidade*/
		$ubs = $this->model_ubs->retorna_ubs();
		$option = "<option value=''></option>";
		foreach($ubs -> result() as $linha) {
			$option .= "<option value='$linha->id_unidade'>$linha->nome_unidade</option>"; 
		}
		$dados = array(
			'titulo' => 'Sistema de Acamados',
			'tela' => 'relatorios/filto_insumo_unidade',
		 	'options_ubs' => $option,
		);
		$this->load->view('index',$dados);
	}

	public function soliberada(){ /*traz a quantidade de insumos solicitado por unidade*/

			$solicitacoesLiberadas = $this->model_relatorios->solicitacoesLiberadas()->result();

				$dados = array(
					'titulo' => 'Sistema de Acamados',
					'tela' => 'relatorios/insumosliberados',
					'query' => $solicitacoesLiberadas
				);		

				$this->load->view('index',$dados);

	}

	public function solRegiao()
	{
		$regioes = $this->model_ubs->retorna_regioes();
		$option = "<option value=''></option>";
		foreach($regioes -> result() as $linha) {
			$option .= "<option value='$linha->id_regiao'>$linha->nome</option>"; 
		}
		$dados = array(
			'titulo' => 'Sistema de Acamados',
			'tela' => 'relatorios/filto_sol_regiao',
		 	'options' => $option,
		);
		$this->load->view('index',$dados);
		
	}
	public function regiao()
	{
		$id_sol = $this->uri->segment(3);
		if ($id_sol != null)
		{
			$solicitacao = $this->model_sol->getSolicitacoById($id_sol)->row();
			$pacientes = $this->getPacientes($solicitacao->id_cad_pacientes_cad_pacientes);
			$ubs = $this->getOptUbs($solicitacao->id_cad_pacientes_cad_pacientes);
			$tipos = $this->getOptTipo($solicitacao->id_tipo_solicitacao);
			$dados = array(
				'titulo' => 'Sistema de Acamados',
				'tela' => 'relatorios/teste',
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
		else 
		{
			$regioes = $this->model_ubs->retorna_regioes();
			$option = "<option value=''></option>";
			foreach($regioes -> result() as $linha) {
				$option .= "<option value='$linha->id_regiao'>$linha->nome</option>"; 
			}
			if (!empty($_POST['id_regiao'])) {
				$result = $this->model_relatorios->solicitacoesRegiao($_POST['id_regiao'])->result();
			} else {
				redirect("relatorio/solRegiao");
			}
			$dados = array(
				'titulo' => 'Sistema de Acamados',
				'tela' => 'relatorios/result_sol_regiao',
			 	'options_ubs' => $option,
			 	'resultado' => $result,
			);
			$this->load->view('index',$dados);			
		}
	}
	
}
?>