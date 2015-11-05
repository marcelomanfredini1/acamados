<div class="col-lg-10 center">
	<div class="well bs-component">

<?php
	function getOptQtd($id_insumo = 0)
	{
		if ($id_insumo == 0) {	
			return '';
		}else{
			foreach($qtd_insumos -> result() as $linha) {
				if ($id_insumo == $linha->id_cad_insumos){
					$qtd = $linha->quantidade;
				}			
			}
			return $qtd;
		}
	}

	$atriForm = array('class' => 'form-horizontal',);
	echo form_open("solicitacoes/editar/$id", $atriForm);
	$attr_label = array(
    'class' => 'col-lg-2 control-label',
	);
	echo "<fieldset>
	<div class=\"form-group\">";
	echo validation_errors('<div class="alert alert-dismissable alert-danger"><button type="button" class="close" data-dismiss="alert">x</button>','</div>');
	if ($this->session->flashdata('edicaook')) {
		echo '<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert">x</button>'. $this->session->flashdata('edicaook').'</div>';	
	}
		if ($this->session->flashdata('alert')) {
		echo '<div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert">x</button>'. $this->session->flashdata('excluirok').'</div>';	
	}
	if ($this->session->flashdata('adcOk')) {
		echo $this->session->flashdata('adcOk');	
	}
	echo '
	<div class="control-group">
		<label class="col-lg-2 control-label" for="paciente">Paciente</label>
			<div class="col-lg-10">
				<select class="input-xxlarge form-control" name="id_cad_pacientes_cad_pacientes" id="paciente" type="text" placeholder=".input-xxlarge" onChange = "javascript: carrega_ubs();" readonly disabled>
					'.$pacientes.'
				</select>
			</div>
		<label class="col-lg-2 control-label">UBS:</label>
			<div class="col-lg-10">
				<select class="input-xxlarge form-control" name="id_unidade" id="ubs" type="text" placeholder=".input-xxlarge" readonly disabled>
					'.$ubs.'
				</select>
			</div>
		<label class="col-lg-2 control-label">Tipo Solicitação:</label>
			<div class="col-lg-4">
				<select class="input-xxlarge form-control" name="id_tipo_solicitacao_tipo_solicitacao" type="text" placeholder=".input-xxlarge" readonly disabled>
					'.$tipos.'
				</select>
			</div>
		<div class="col-lg-5">
		</div>
	</div>
	</div>
	';
	//echo form_submit(array('name' => 'btnCadastrar','class' => 'btn btn-primary'),'Salvar');
	echo form_close();
?>
<div id="tabs-1">
	<table class="display table table-striped table-hover table-condensed" id="insumos_solicitados">
		<thead> 
			<tr>
				<th class="span2">Codigo</th>
				<th class="span2">Insumo</th>
				<th class="span2">Quantidade</th>
				<th class="span2">Observação</th>
			</tr>
		</thead>
	<tbody>
<?php 
	foreach ($insumos as $insumo) {
		$id_is = $insumo->codigo;
		$u_insumo = $insumo->nome_insumo;
		$quantidade = $insumo->quantidade;
		$obs = $insumo->observacao;
		echo "<tr class='gradeA'>";
     	echo "<td><center><font face='helvetica' font size='2'>$id_is</font></center></td>";
     	echo "<td><center><font face='helvetica' font size='2'>$u_insumo</font></center></td>";
     	echo "<td><center><font face='helvetica' font size='2'>$quantidade</font></center></td>";
     	echo "<td><center><font face='helvetica' font size='2'>$obs</font></center></td>";		
	}
?>
</tbody>
</table>
</div>
</div>

<?php
	// Botão voltar para tela anterior!	
	echo anchor('relatorio/insporuni', 'VOLTAR', 'class="btn btn-primary"');

?>

</div>



<script>
	//Todos scripts dentro de Document.Ready são Jquery 
	$(document).ready(function() {
		$('#insumos_solicitados').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"sDom": '<"H"Tlfr>t<"F"ip>',
			"oTableTools": {
				"sSwfPath": "<?php echo base_url(); ?>/padrao/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
				"aButtons": [ 
					{ 
						"sExtends": "xls",
						"sButtonText": "Exportar para Excel",
						"sTitle": "Insumos Solicitados",
						"mColumns": [0, 1, 2, 3]
					},
					{
						"sExtends": "pdf",
						"sButtonText": "Exportar para PDF",
						"sTitle": "Insumos Solicitados",
						"sPdfOrientation": "landscape",
						"mColumns": [0, 1, 2, 3] 
					} 
				] 
			},
			"oLanguage": {
				"sLengthMenu": "<font face='helvetica' font size='2'>Mostrar _MENU_ registros por página</font>",
				"sZeroRecords": "<font face='helvetica' font size='2'>Nenhum registro encontrado</font>",
				"sInfo": "<font face='helvetica' font size='2'>Mostrando _START_ / _END_ de _TOTAL_ registro(s)</font>",
				"sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
				"sInfoFiltered": "(filtrado de _MAX_ registros)",
				"sSearch": "<font face='helvetica' font size='2'>Pesquisar:</font> ",
				"oPaginate": {
					"sFirst": "Início ",
					"sPrevious": " Anterior ",
					"sNext": " Próximo ",
					"sLast": " Último "
				}
			},
			"aaSorting": [[0, 'desc']],
			"aoColumnDefs": [
				{"sType": "num-html", "aTargets": [0]}
			]
		});
	})
	;//fim jquery
</script>