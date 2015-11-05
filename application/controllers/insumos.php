<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Insumos extends MY_Controller {
	function __construct() {
		parent::__construct();
	}
	public function newInsumos() 
{

		$this->form_validation->set_rules('nome_insumo','Insumo','trim|required|max_length[50]|ucwords');
		$this->form_validation->set_rules('id_unidade_de_medida_unidade_de_medida','Unidade de Medida','trim|required|max_length[50]');
		$this->form_validation->set_rules('quantidade','Quatidade','trim|required|max_length[10]|integer');
		$this->form_validation->set_rules('periodo_dias','Periodo em dias','trim|required|max_length[10]|integer');
		if($this->form_validation->run()==TRUE){
			$dados = elements(
					array(
						'nome_insumo',
						'id_unidade_de_medida_unidade_de_medida',
						'quantidade',
						'periodo_dias'
					),$this->input->post());
			$this->model_insumos->inserirInsumo($dados);
		}		
		$udms = $this->model_udm->retorna_udms();
		$udm_options = "<option value=''></option>";
		foreach($udms -> result() as $linha) {
			$udm_options .= '<option value="'.$linha->id_unidade_de_medida.'">'.$linha->nome.'</option>';
		}
		$dados = array(
			'title' => 'Adicionar Insumo',
			'tela' => '/insumos/newInsumos',
			'options_udm' => $udm_options,
		);
		$this->load->view('index',$dados);
		}
	public function colInsumos() 
{
		$dados = array(
			'title' => 'Consultar Insumos',
			'tela' => '/insumos/colInsumos',
			'insumos' => $this->model_insumos->get_all()->result(),
		);
		$this->load->view('index',$dados);
	}
	public function editar()
{
		$this->form_validation->set_rules('nome_insumo','Insumo','trim|required|max_length[50]|ucwords');
		$this->form_validation->set_rules('id_unidade_de_medida_unidade_de_medida','Unidade de Medida','trim|required|max_length[50]');
		$this->form_validation->set_rules('quantidade','Quatidade','trim|required|max_length[10]|integer');
		$this->form_validation->set_rules('periodo_dias','Periodo em dias','trim|required|max_length[10]|integer');
		if($this->form_validation->run()==TRUE){
			$dados = elements(
					array(
						'nome_insumo',
						'id_unidade_de_medida_unidade_de_medida',
						'quantidade',
						'periodo_dias'
					),$this->input->post());
			$this->load->view('index',$dados);
			$id = $this->input->post('id_cad_insumos');
			$this->model_insumos->do_update($dados,$id);
		}
		
		$id_insumo = $this->uri->segment(3);
		if ($id_insumo == null) {
			redirect('insumos/colInsumos');
		}
		$insumo = $this->model_insumos->get_byid($id_insumo)->row();
		$udms = $this->model_udm->retorna_udms();
		$udm_options = "<option value=''></option>";
		foreach($udms -> result() as $linha) {
			if ($linha->id_unidade_de_medida == $insumo->id_unidade_de_medida_unidade_de_medida)
			{
				$udm_options .= '<option selected="selected" value="'.$linha->id_unidade_de_medida.'">'.$linha->nome.'</option>';
			}
			else
			{
				$udm_options .= '<option value="'.$linha->id_unidade_de_medida.'">'.$linha->nome.'</option>';
			}
		}
		$dados = array(
		'title' =>'Editar de Insumo',
		'tela' => 'insumos\editInsumos',
		'options_udm' => $udm_options,
		'insumo' => $insumo,
		'id_insumo' => $id_insumo,
		);
		$this->load->view('index',$dados);
	}
	public function deletar()
	{
		$id_cad_insumos = $this->uri->segment(3);
		if ($id_cad_insumos == null) {
			redirect('insumos/colInsumos');
		}
		else
		{
			$this->model_insumos->do_delete(array('id_cad_insumos'=>$id_cad_insumos));		
		}
	}
	
}