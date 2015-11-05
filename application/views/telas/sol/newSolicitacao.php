<div class="col-lg-10 center">
	<div class="well bs-component">
<?php
	if ($this->session->flashdata('errodup')) {
			echo '<p>'. $this->session->flashdata('errodup').'</p>';	
	}
	$atriForm = array('class' => 'form', 'name' => 'sol_insumos');
	$tmpl = array ('table_open'          => '<table  class="table table-striped table-hover">',
                    'heading_row_start'   => '<tr>',
                    'heading_row_end'     => '</tr>',
                    'heading_cell_start'  => '<th>',
                    'heading_cell_end'    => '</th>',
                    'row_start'           => '<tr class="primary">',
                    'row_end'             => '</tr>',
                    'cell_start'          => '<td>',
                    'cell_end'            => '</td>',
                    'row_alt_start'       => '<tr>',
                    'row_alt_end'         => '</tr>',
                    'cell_alt_start'      => '<td>',
                    'cell_alt_end'        => '</td>',
                    'table_close'         => '</table>'
              );			  
	$this->table->set_heading('ID', 'Nome', 'Quantidade','Observação','Operações');
    $this->table->set_template($tmpl);
	//$dadosTabela = array();
	echo form_open('solicitacoes/newSolicitacao', $atriForm);
	$attr_label = array(
    	'class' => 'col-lg-2 control-label',
	);
	echo "<fieldset>
	<div class=\"form-group\">";
		
		echo validation_errors('<div class="alert alert-dismissable alert-danger"><button type="button" class="close" data-dismiss="alert">x</button>','</div>');
		if ($this->session->flashdata('cadastrook')) {
			echo '<p>'. $this->session->flashdata('cadastrook').'</p>';	
		}
		
		echo form_label('<font face="helvetica" font size="2">Paciente:</font>','paciente',$attr_label);
		echo "<div class=\"col-lg-10\">";
		echo '<select class="input-large form-control" name="id_cad_pacientes_cad_pacientes" id="paciente" type="text" onChange = "javascript: carrega_ubs();">
			'.$pacientes.'
			  </select>';
		echo "</div>";
		echo ' <br /><br /><br />';

		echo form_label('<font face="helvetica" font size="2">UBS:</font>','id_unidade',$attr_label);
		echo "<div class=\"col-lg-4\">";
		echo '<select class="input-large form-control" name="id_unidade" id="ubs" type="text" placeholder=".input-xxlarge" disabled>
			'.$ubs.'
			  </select>';
		echo "</div>";
		
		echo form_label('<font face="helvetica" font size="2">Tipo Solicitação:</font>','id_tipo_solicitacao_tipo_solicitacao',$attr_label);
		echo "<div class=\"col-lg-4\">";
		echo '<select class="input-large form-control" name="id_tipo_solicitacao_tipo_solicitacao" id="id_tipo_solicitacao_tipo_solicitacao" type="text" placeholder=".input-xxlarge">
			 '.$tipos.'
			  </select>';
		echo "</div>";
		echo ' <br /><br /><br />';
		
		echo form_label('<font face="helvetica" font size="2">Status:</font>','status',$attr_label);
		echo "<div class=\"col-lg-4\">";
		echo '<select class="input-large form-control" name="status" id="status" type="text" placeholder=".input-xxlarge">
				<option value="Fila de Espera">Fila de Espera</option>
				<option value="Liberado">Fila de Liberado</option>
				<option value="Inativo">Inativo</option>
			  </select>';
		echo "</div>";
	echo "</div>";
				
		//-----------------------------------------------------------------------------------------------//
		echo '<div class="form-inline">
			<legend><br />Adicione um insumo e quantidade a lista: </legend>
			<div class="control-group">';
				echo form_label('<font face="helvetica" font size="2">Insumo:</font>','id_cad_insumos_cad_insumos',$attr_label);
				echo "<div class=\"col-lg-10\">";
				echo '<select class="input-large form-control" name="id_cad_insumos_cad_insumos" id="id_cad_insumos_cad_insumos" type="text" placeholder=".input-xxlarge" onChange = "javascript: carrega_qtd();">
					 '.$insumos.'</select>';
				echo "</div>";
				echo ' <br /><br /><br />';
				
				echo form_label('<font face="helvetica" font size="2">Quantidade:</font>','quantidade',$attr_label);
				echo "<div class=\"col-lg-4\">";
				echo '<input type="text" name="quantidade" id="quantidade" value="'.$quantidade.'" class="form-control disable">';
				echo "</div>";
				
				echo form_label('<font face="helvetica" font size="2">Observação:</font>','observacao',$attr_label);
				echo "<div class=\"col-lg-4\">";
				echo form_input(array('name' => 'observacao', 'id'=>'observacao', 'class'=>'form-control'),set_value('observacao'));
				echo '</div>';
				echo ' <br /><br /><br />';
				echo "<div class=\"col-lg-5\">";
				echo ' <br />';
				echo "</div>";
				echo "<div class=\"col-lg-2\">";
				
				echo form_submit(array('name' => 'adiciona', 'id'=>'btnadicionar', 'class' => 'btn btn-primary form-control', 'onclick' => 'javascript: muda_value();'),'Adicionar');
				echo '<br /><br /></div>';
			echo "</div>";
		echo "</div>";
		$fl=1;
		foreach ($ok as $linha) {
			if (!empty($linha['id_cad_insumos_cad_insumos'])) {
				$fl=0;
			}
			$this->table->add_row($linha['id_cad_insumos_cad_insumos'],$linha['nome'], $linha['quantidade'], $linha['observacao'],$linha['operacoes']);
		}
		if ($fl == 0)
		echo $this->table->generate();		
		echo ' <br />';
		echo ' <br />';
		echo ' <br />';
		echo ' <br />';
		echo ' <br />';
		echo "<div class=\"col-lg-3\">";
		echo "</div>";
		echo "<div class=\"col-lg-2\">";
		echo '<a class="btn btn-danger form-control" href="'. base_url("solicitacoes/destroy").'">Limpar</a>';
		echo "</div>";
		echo "<div class=\"col-lg-1\">";
		echo "</div>";
		echo "<div class=\"col-lg-2\">";
		echo form_submit(array('name' => 'btnCadastrar','id'=>'btnCadastrar','class' => 'btn btn-primary form-control','onclick' => 'javascript: salvar();'),'Salvar');
		echo "</div>";
		echo "<fieldset>
		</div>"; 
		echo form_close();
?>
</div>

<script type="text/javascript" charset="utf-8">
	function muda_value()
	{
		document.sol_insumos.action = '<?php echo base_url(); ?>solicitacoes/newSolicitacao/7';
		document.sol_insumos.submit();
	}
	function carrega_ubs()
	{
		document.sol_insumos.action = '<?php echo base_url(); ?>solicitacoes/newSolicitacao/5';
		document.sol_insumos.submit();
	}
	function carrega_qtd()
	{
		document.sol_insumos.action = '<?php echo base_url(); ?>solicitacoes/newSolicitacao/6';
		document.sol_insumos.submit();
	}
	function salvar()
	{
		document.sol_insumos.action = '<?php echo base_url(); ?>solicitacoes/newSolicitacao/9';
		document.sol_insumos.submit();
	}
/* Bloqueia os botões até que sejam preenchidos todos os campos*/

	$("#btnadicionar").attr("disabled","disabled");
	$("#btnCadastrar").attr("disabled","disabled");
	$("#paciente,#ubs,#id_tipo_solicitacao_tipo_solicitacao,#status,#id_cad_insumos_cad_insumos,#quantidade,#observacao").keyup(function(){
	  //alert("Passou aqui");			
		 if($("#paciente"							 ).val()!="" && 
		 	$("#ubs"        						 ).val()!="" && 
		 	$("#id_tipo_solicitacao_tipo_solicitacao").val()!="" && 
		 	$("#status"   							 ).val()!="" && 
		 	$("#id_cad_insumos_cad_insumos"          ).val()!="" && 
		 	$("#quantidade"							 ).val()!="" && 
		 	$("#observacao"    						 ).val()!=""){

		 	$("#btnadicionar").removeAttr("disabled");
		 	$("#btnCadastrar").removeAttr("disabled");	
		}
		else{
			$("#btnadicionar").attr("disabled","disabled");
			$("#btnCadastrar").attr("disabled","disabled");
		}
	});	

</script>
