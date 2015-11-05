<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Pacientes extends MY_Controller {
	function __construct() {
		parent::__construct();
	}
	public function newPaciente()
	{		
		$this->form_validation->set_rules('nome_paciente','Nome','trim|required|max_length[50]|ucwords');
		$this->form_validation->set_rules('dt_entrada','Data de Entrada','trim|required|callback_date_valid');
		$this->form_validation->set_rules('dt_nascimento','Data de Nascimento','trim|required|callback_date_valid');
		//$this->form_validation->set_rules('dt_baixa','Data da Baixa','trim|callback_date_valid'); /*Novo*/
		$this->form_validation->set_rules('idade','Idade','trim|required|max_length[3]|integer|is_natural_no_zero');
		$this->form_validation->set_rules('peso','Peso','trim|required|max_length[6]|min_length[2]|numeric');
		$this->form_validation->set_rules('fone','Telefone','trim|required|max_length[10]|min_length[9]');
		$this->form_validation->set_rules('patologia','Patologia','trim|required');
		$this->form_validation->set_rules('cid','CIDs','trim|required');
		$this->form_validation->set_rules('id_unidade','Unidade Basica','trim|required|numeric|max_length[3]');
		$this->form_validation->set_rules('cns','CNS','trim|required|max_length[15]|integer|is_natural_no_zero');
		if($this->form_validation->run()==TRUE){
			if(!$this->input->post('dt_baixa')){
				$dados = elements(
				array(		
				'nome_paciente',
				'dt_entrada',
				'dt_nascimento',
				'idade',
				'peso',
				'fone',
				'patologia',
				'cid',
				'id_unidade',
				'cns'),$this->input->post());
				$this->model_pacientes->inserirPaciente($dados);
			}
			else
			{
				$dados = elements(
				array(		
				'nome_paciente',
				'dt_entrada',
				'dt_baixa',
				'dt_nascimento',
				'idade',
				'peso',
				'fone',
				'patologia',
				'cid',
				'id_unidade',
				'cns'),$this->input->post());
				$this->model_pacientes->inserirPaciente($dados);
				echo "<h1>tudo ok</h1>";
			}
		} 
		
		 
		$ubs = $this->model_ubs->retorna_ubs();
		$option = "<option value=''></option>";
		foreach($ubs -> result() as $linha) {
			$option .= "<option value='$linha->id_unidade'>$linha->nome_unidade</option>"; 
		}
		$cids = $this->model_cids->retorna_cids();
		$cid_option = "<option value=''></option>";
		foreach($cids -> result() as $linha) {
			$cid_option .= "<option value='$linha->id'>$linha->descricao</option>"; 
		}
		 $dados = array(
		 'title' => 'Criar Paciente',
		 'tela' => 'newPaciente',
		 'options_ubs' => $option,
		 'options_cids' => $cid_option,
		 );
		 $this->load->view('index',$dados);
	}
	public function colPaciente()
	{
		$ubs = $this->model_ubs->retorna_ubs();
		$dados = array(
		'title' =>'Consulta de Pacientes',
		'tela' => 'colPacientes',
		'pacientes' => $this->model_pacientes->get_all()->result(),
		'ubs' => $ubs,
		);
		$this->load->view('index',$dados);
	}
	public function editar()
	{
		$this->form_validation->set_rules('nome_paciente','Nome','trim|required|max_length[50]|ucwords');
		$this->form_validation->set_rules('dt_nascimento','Data de Nascimento','trim|required|callback_date_valid');
		$this->form_validation->set_rules('idade','Idade','trim|required|max_length[3]|integer|is_natural_no_zero');
		$this->form_validation->set_rules('peso','Peso','trim|required|max_length[6]|min_length[2]|numeric');
		$this->form_validation->set_rules('fone','Telefone','trim|required|max_length[10]|min_length[8]');
		$this->form_validation->set_rules('patologia','Patologia','trim|required');
		$this->form_validation->set_rules('cid','CIDs','trim|required');
		$this->form_validation->set_rules('id_unidade','Unidade Basica','trim|required|numeric|max_length[3]');
		$this->form_validation->set_rules('cns','CNS','trim|required|max_length[15]|integer|is_natural_no_zero');
		if($this->form_validation->run() == TRUE)
		{
			$dados = elements(array('nome_paciente',
									'dt_nascimento',
									'idade',
									'peso',
									'fone',
									'patologia',
									'cid',
									'id_unidade',
									'cns'),
									$this->input->post());
			$id = $this->input->post('id_cad_pacientes');
			$this->model_pacientes->do_update($dados,$id);
			//$this->load->view('index',$dados);	
		}
		$id_user = $this->uri->segment(3);
		if ($id_user == null) {
			redirect('pacientes/colPaciente');
		}
		$user = $this->model_pacientes->get_byid($id_user)->row();
		$ubs = $this->model_ubs->retorna_ubs();		
		$option = "<option value=''></option>";
		foreach($ubs -> result() as $linha) {
			if ($linha->id_unidade == $user->id_unidade)
			{
			$option .= '<option selected="selected" value='.$linha->id_unidade.'>'.$linha->nome_unidade.'</option>';
			}
			else
			{
			$option .= "<option value='$linha->id_unidade'>$linha->nome_unidade</option>"; 
			}			
		}
		$cids = $this->model_cids->retorna_cids();
		$cid_option = "<option value=''></option>";
		foreach($cids -> result() as $linha) {
			if ($linha->id == $user->cid)
			{
			$cid_option .= '<option selected="selected" value="'.$linha->id.'">'.$linha->descricao.'</option>';
			}
			else
			{
			$cid_option .= "<option value='$linha->id'>$linha->descricao</option>";
			}
		}
		$dados = array(
		'title' =>'Editar de Paciente',
		'tela' => 'editPaciente',
		'ubs' => $option,
		'user' => $user,
		'id_user' => $id_user,
		'options_cids' =>$cid_option,
		);
		$this->load->view('index',$dados);
		
	}
	public function deletar()
	{
		$id_user = $this->uri->segment(3);
		if ($id_user == null) {
			redirect('pacientes/colPaciente');
		}
		else
		{
			$this->model_pacientes->do_delete(array('id_cad_pacientes'=>$id_user));		
		}
		
	}
	public function date_valid($date)
	{
		// CHAMANDO $this->form_validation->set_rules('date', 'Date', 'required|callback_date_valid');
		$parts = explode("-", $date);
		if (count($parts) == 3)
		{      
			if (checkdate($parts[1], $parts[0], $parts[2]))
			{
				return TRUE;
			}
		}
		$this->form_validation->set_message('date_valid', 'Campo de data não foi preenchido corretamente dd-mm-yyyy');
		return false;
	}
	
}