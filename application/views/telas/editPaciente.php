<div class="col-lg-10 center">
	<div class="well bs-docs-example">
<?php
	$atriForm = array('class' => 'form-horizontal',);
	echo form_open("pacientes/editar/$id_user", $atriForm);
	$attr_label = array(
    'class' => 'col-lg-2 control-label',
	);
	echo "<fieldset>
	<div class=\"form-group\">";
	echo validation_errors('<div class="alert alert-dismissable alert-danger""><button type="button" class="close" data-dismiss="alert">x</button>','</div>');
	if ($this->session->flashdata('edicaook')) {
		echo '<div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert">x</button>'. $this->session->flashdata('edicaook').'</div>';	
	}	
	
	echo form_label('<font face="helvetica" font size="2">Nome de Usuario: </font>','nome_paciente',$attr_label);
	echo "<div class=\"col-lg-10\">";
	echo form_input(array('name' => 'nome_paciente','id' => 'nome_paciente', 'class' => 'form-control'),set_value('nome_paciente',$user->nome_paciente),'autofocus');
	echo "</div>";
	
	echo form_label('<font face="helvetica" font size="2">Data de Nascimento: </font>','campoData2',$attr_label);
	echo "<div class=\"col-lg-4\">";
	$fDate = date("d-m-Y", strtotime($user->dt_nascimento));
	echo form_input(array('name' => 'dt_nascimento', 'id'=> 'campoData2', 'class' => 'form-control'),set_value('dt_nascimento',$fDate));
	echo "</div>";
	
	echo form_label('<font face="helvetica" font size="2">Idade: </font>','idade',$attr_label);
	echo "<div class=\"col-lg-4\">";
	echo form_input(array('name' => 'idade','id' => 'idade', 'class' => 'form-control'),set_value('idade',$user->idade));
	echo "</div>";
	
	echo form_label('<font face="helvetica" font size="2">Peso: </font>','peso',$attr_label);
	echo "<div class=\"col-lg-4\">";
	echo form_input(array('name' => 'peso', 'id'=>'peso', 'class' => 'form-control'),set_value('peso',$user->peso));
	echo "</div>";
	
	echo form_label('<font face="helvetica" font size="2">Telefone: </font>','campoTelefone',$attr_label);
	echo "<div class=\"col-lg-4\">";
	echo form_input(array('name' => 'fone', 'id'=> 'campoTelefone', 'class' => 'form-control'),set_value('fone',$user->fone));
	echo "</div>";
	
	echo form_label('<font face="helvetica" font size="2">Patologia: </font>','patologia',$attr_label);
	echo "<div class=\"col-lg-4\">";
	echo form_input(array('name' => 'patologia','id' => 'patologia', 'class' => 'form-control'),set_value('patologia',$user->patologia));
	echo "</div>";	
	
	echo form_label('<font face="helvetica" font size="2">CIDs: </font>','cids',$attr_label);
	echo "<div class=\"col-lg-4\">";
	echo '<select class="input-xxlarge form-control" name="cid" id="cids">
			'.$options_cids.'
			</select>';
	echo "</div>";

	echo form_label('<font face="helvetica" font size="2">CNS: </font>','campoCns',$attr_label);
	echo "<div class=\"col-lg-4\">";
		echo form_input(array('name' => 'cns','id' => 'campoCns', 'class' => 'form-control', 'placeholder'=>"CNS..."),set_value('cns', $user->cns));
	echo "</div>";	
	
	echo form_label('<font face="helvetica" font size="2">Escolha a UBS: </font>','ubs',$attr_label);
	echo "<div class=\"col-lg-4\">";
	echo '<select class="input-xlarge form-control" name="id_unidade" id="ubs" type="text" placeholder=".input-xxlarge">
			'.$ubs.'
			</select><br/>';
	echo "</div>";
	
	echo "<div class=\"col-lg-5\">";
	echo "</div>";
	
	echo "<div class=\"col-lg-2\">";
    echo form_submit(array('name' => 'cadastrar', 'id' => 'btncadastrar','class' => 'btn btn-primary align-center'),'Alterar');
	echo "</div>";
	
	echo form_hidden('id_cad_pacientes',$user->id_cad_pacientes);
	form_close('pacientes/editar');
	echo "<div class=\"col-lg-2\">";
	echo '<a href="'.base_url("pacientes/colPaciente").'" class="btn btn-danger">Cancelar</a>
	</div>';
?>
</div>
</div>
</div>
<script>
	jQuery(function($){
		$("#campoData").mask("99-99-9999");
		$("#campoData1").mask("99-99-9999");
		$("#campoData2").mask("99-99-9999");
		$("#campoCns").mask("999999999999999");
	});

	//$("#btncadastrar").attr("disabled","disabled");
		$("#nome_paciente,#idade,#campoData,#campoData2,#peso,#campoTelefone,#patologia,#campoCns,#cids,#ubs").keyup(function(){
		  //alert("Passou aqui");			
			 if($("#nome_paciente").val()!="" && 
			 	$("#idade"        ).val()!="" && 
			 	$("#campoData"    ).val()!="" && 
			 	$("#campoData2"   ).val()!="" && 
			 	$("#peso"         ).val()!="" && 
			 	$("#campoTelefone").val()!="" && 
			 	$("#patologia"    ).val()!="" && 
			 	$("#campoCns"     ).val()!="" &&
			 	$("#cids"         ).val()!="" &&
			 	$("#ubs"          ).val()!=""){

			 	$("#btncadastrar").removeAttr("disabled");	
			}
			else{
				$("#btncadastrar").attr("disabled","disabled");
			}
		});	




</script>