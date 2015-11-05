<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public function __construct() {
			parent::__construct();
	}	
	public function index(){
		$this->load->view('login');	
	}
	public function Validar() {
		$this->form_validation->set_rules('nome','nome','trim|required|callback__check_login');
			if($this->form_validation->run()==TRUE){
				$session = array('logado' => 1);
				$this->session->set_userdata($session);
				/*$dados = array (
					'tela' => 'inicio',
				);
				$this->load->view('index',$dados);
				 * 
				 */
				 redirect('index');
			}else{
				$this->load->view('login');
			}
	}
	public function logoff(){
		$this->session->sess_destroy();
		redirect('login');
	}
	public function _check_login($nome) {
		if($this->input->post('senha')){
			$user = $this->model_users->get_usuario($nome,md5($this->input->post('senha')));
				if($user) return true;
		}
		$this->form_validation->set_message('_check_login','Usuários / Senha Errado(s)');
		return false;
	}

	public function asenha() {

		$dados = array(
			'title' => 'Alterar senha',
			'tela' => 'alterarsenha',
		);
		$this->load->view('index',$dados);

	}

	public function senha (){/*Alterar a senha*/

		/*Valida se o campo foi preenchido e se é igual ao outro*/
		$this->form_validation->set_rules('senha', 'senha', 'required|matches[senha2]');
		$this->form_validation->set_rules('senha2', 'senha2', 'required');

		if($this->form_validation->run() == TRUE) { /*Caso não existam erros ele grava*/

			$senha = array (

				'senha' => md5($this->input->post('senha'))

			);

			$this->session->set_userdata('aviso','Senha alterada com sucesso!');

			$this->model_users->alterarSenha($senha);
			redirect('login/asenha/');

		} else {/*Em caso de erros*/

			$this->session->set_userdata('aviso','Senha não confere!');
			redirect('login/asenha/');

		}
	}
	
}
			/*
		$this->form_validation->set_rules('nome','Nome','trim|required|callback__check_login');
		$this->form_validation->set_rules('senha','Senha','trim|required');		
		if($this->form_validation->run()==TRUE){
			//chamar um aviso na view...
			$dados_login = array(
			'nome_usuario' => $nome,
			'logado' => 1
			);
			$this->session->userdata($dados_login);
			//redirect('acamados');
			} else {
			$dados = array(
				'titulo' => 'Sistema de Acamados',
				'tela' => 'index'
				);		
			$this->load->view('index',$dados);
			}
			
	}

	public function _check_login($nome) {
		
		if($this->input->post('senha'))
		{
			$user = $this->model_users->get_usuario($nome,$this->input->post('senha'));

			if(isset($user)){
				return true;
			}else{
				return false;
			}

		}
		$this->form_validation->set_message('_check_login','Usuários / Senha Errado(s)');
		return false;
			 */