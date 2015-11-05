<div class="col-lg-10 center">
	<div class="well bs-docs-example">
<?php
	$atriForm = array('class' => 'form-horizontal',);
	$atriForm = array('class' => 'form',);
	echo form_open("insumos/editar/$id_insumo", $atriForm);
	$attr_label = array(
    	'class' => 'col-lg-2 control-label',
	);
	echo "<fieldset>
	<div class=\"form-group\">";
	echo validation_errors('<div class="alert alert-block alert-danger"><button type="button" class="close" data-dismiss="alert">x</button>','</div>');
	if ($this->session->flashdata('edicaook')) {
		echo '<div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert">x</button>'. $this->session->flashdata('edicaook').'</div>';	
	}		
	echo form_label('Nome do Insumo:','nome_insumo',$attr_label);
	echo "<div class=\"col-lg-4\">";
		echo form_input(array('name' => 'nome_insumo', 'id'=>'nome_insumo', 'class' => 'form-control'),set_value('nome_insumo',$insumo->nome_insumo),'autofocus');
	echo "</div>";
	echo form_label('Unidade de Medida:','id_unidade_de_medida_unidade_de_medida',$attr_label);
	echo "<div class=\"col-lg-4\">";
		echo '<select class="input-large form-control" name="id_unidade_de_medida_unidade_de_medida" id="id_unidade_de_medida_unidade_de_medida">
			'.$options_udm.'
			</select>';
	echo "</div>";
	echo form_label('Quantidade:','quantidade',$attr_label);
	echo "<div class=\"col-lg-4\">";
		echo form_input(array('name' => 'quantidade', 'id' => 'quantidade','class' => 'form-control'),set_value('quantidade',$insumo->quantidade));
	echo "</div>";
	echo form_label('Periodo da cota:','periodo_dias',$attr_label);
	echo "<div class=\"col-lg-4\">";
		echo form_input(array('name' => 'periodo_dias', 'id' => 'periodo_dias','class' => 'form-control'),set_value('periodo_dias',$insumo->periodo_dias));
	echo "</div>";
	echo "</div>";
	echo "<div class=\"col-lg-5\">";
	echo "</div>";
	echo "<div class=\"col-lg-2\"><br />";
    	echo form_submit(array('name' => 'cadastrar', 'id' => 'btncadastrar', 'class' => 'btn btn-primary align-center'),'Alterar');
	echo "</div>";
	echo form_hidden('id_cad_insumos',$insumo->id_cad_insumos);
	form_close('insumos/editar');	
	echo "<div class=\"col-lg-2\"><br />";
    	echo '<a href="'.base_url("insumos/colInsumos").'" class="btn btn-danger">Cancelar</a>
		</div>';
	
?>
</div>	
</div>	
<script>

		$("#nome_insumo,#id_unidade_de_medida_unidade_de_medida,#quantidade,#periodo_dias").keyup(function(){
		  //alert("Passou aqui");			
			 if($("#nome_insumo").val()!="" && 
			 	$("#id_unidade_de_medida_unidade_de_medida"        ).val()!="" && 
			 	$("#quantidade"    ).val()!="" && 
			 	$("#periodo_dias"   ).val()!=""){

			 	$("#btncadastrar").removeAttr("disabled");	
			}
			else{
				$("#btncadastrar").attr("disabled","disabled");
			}
		});	


</script>	