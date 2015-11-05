<div class="col-tg-10 well bs-component">
<?php
	echo validation_errors('<div class="alert alert-block alert-error"><button type="button" class="close" data-dismiss="alert">x</button>','</div>');
	if ($this->session->flashdata('error')) {
		echo '<div class="alert alert-block alert-danger"><button type="button" class="close" data-dismiss="alert">x</button>'. $this->session->flashdata('error').'</div>';	
	} else if ($this->session->flashdata('success')) {
		echo '<div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert">x</button>'. $this->session->flashdata('success').'</div>';	
	}
	$atriForm = array('class' => 'form-horizontal',);
	echo form_open("solicitacoes/editarInsumo/".$id_cad_insumos_cad_insumos."-".$id_sol_insumos_solicitacao_insumos, $atriForm);
	$attr_label = array(
    'class' => 'col-lg-1 control-label',
	);
	echo "<fieldset>
		<div class=\"form-group\">";
			echo '<div class="control-group">';
				echo form_label('Insumo:','nome_insumo',$attr_label);
				echo "<div class=\"col-lg-5\">";
					$nome_i = array('name' => 'nome_insumo','id' => 'nome_insumo', 'class' => 'form-control', 'disabled' =>'');
					echo form_input($nome_i,set_value('nome_insumo',$insumo->nome_insumo));
				echo "</div>";
				echo form_label('Quantidade:','quantidade',$attr_label);
				echo "<div class=\"col-lg-5\">";
					echo form_input(array('name' => 'quantidade','id' => 'quantidade', 'class' => 'form-control', 'disabled' =>''),set_value('quantidade',$insumo->quantidade));
				echo "</div>";
				echo "<div class=\"col-lg-3\">";
				echo "</div>";
				echo form_label('Observacao:','observacao',$attr_label);
				echo "<div class=\"col-lg-4\">";
					echo form_input(array('name' => 'observacao','id' => 'observacao', 'class' => 'form-control'),set_value('observacao',$insumo->observacao));
				echo "</div>";
				echo "<br />
				<br />
				<br />
				<br />";
				echo "<div class=\"col-lg-5\">";
				echo "</div>";
				echo "<div class=\"col-lg-2\">";
					echo form_submit(array('name' => 'Alterar', 'class' => 'btn btn-primary align-center'),'Alterar');
					
				echo "</div>";
				echo "<div class=\"col-lg-2\">";				
					echo '<a href="'.base_url("solicitacoes/editar/$insumo->id_sol_insumos_solicitacao_insumos").'" class="btn btn-danger">Cancelar</a>';
				echo "</div>";
			echo "</div>";
		echo "</div>";
	echo "</fieldset>";	
	echo form_hidden('id_cad_insumos_cad_insumos',$insumo->id_cad_insumos_cad_insumos);
	echo form_hidden('id_sol_insumos_solicitacao_insumos',$insumo->id_sol_insumos_solicitacao_insumos);
	echo form_close();
	
	
?>

</div>