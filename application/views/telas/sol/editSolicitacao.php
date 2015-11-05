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
				<select class="input-xxlarge form-control" name="id_cad_pacientes_cad_pacientes" id="paciente" type="text" placeholder=".input-xxlarge" onChange = "javascript: carrega_ubs();">
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
				<select class="input-xxlarge form-control" name="id_tipo_solicitacao_tipo_solicitacao" type="text" placeholder=".input-xxlarge">
					'.$tipos.'
				</select>
			</div>
		<div class="col-lg-5">
		</div>
		<div class="col-lg-2">
			'.form_submit(array('name' => 'btnCadastrar','class' => 'btn btn-primary form-control'),'Salvar').'
		</div>
	</div>
	</div>
	';
	//echo form_submit(array('name' => 'btnCadastrar','class' => 'btn btn-primary'),'Salvar');
	echo form_close();

	// Editando Label do campo, conforme o status atual no banco de dados o label do campo altera INICIO.

		if($status[0]->status == 'Liberado') {

			$label = 'deixar em espera';//Alterar nome do botão.
			$btn = 'warning'; //Alterar tipo do botão.

		} else {

			$label = 'Liberar';//Alterar nome do botão.
			$btn = 'success'; //Alterar tipo do botão.

		}

	// Editando Label do campo, conforme o status atual no banco de dados o label do campo altera FIM.

	//Botão que ira chamar a função no controler que irá alterar o status no banco de dados INICIO.

		echo '<div class="offset2"> 
				<a href="#AddModal'.$id.'" class="btn btn-primary" role="button" data-toggle="modal"> 
				Adicionar Novo Insumo </a>
				'.anchor("solicitacoes/liberarInsumos/".$this->uri->segment(3),$label,'<i class="btn btn-'.$btn.'"></i').' 
			</div>';

	//Botão que ira chamar a função no controler que irá alterar o status no banco de dados FIM.

	$anchor_edit = array('class'=>"label label-warning");
	anchor("solicitacoes/editarInsumos/$id",'Editar Insumos Solicitados',$anchor_edit);
	//print_r($insumos);

	$anchor_delete = array('class'=>"btn  btn-danger");
	$anchor_edit = array('class'=>"label label-warning");
	$anchor_add = array('class'=>"btn btn-primary");
?>
<div id="tabs-1">
	<table class="display table table-striped table-hover table-condensed" id="insumos_solicitados">
		<thead> 
			<tr>
				<th class="span2">Codigo</th>
				<th class="span2">Insumo</th>
				<th class="span2">Quantidade</th>
				<th class="span2">Observação</th>
				<th class="span2">Operações</th>
			</tr>
		</thead>
	<tbody>
<?php 
	foreach ($insumos as $insumo) {
		$id_is = $insumo->codigo;
		$u_insumo = $insumo->nome_insumo;
		$quantidade = $insumo->quantidade;
		$obs = $insumo->observacao;
		$id_ref=$insumo->id_cad_insumos_cad_insumos.'-'.$insumo->id_sol_insumos_solicitacao_insumos;
		$id_deletar=$insumo->id_cad_insumos_cad_insumos.'/'.$insumo->id_sol_insumos_solicitacao_insumos;
		$operacoes = anchor("solicitacoes/editarInsumo/$id_ref",'Editar',$anchor_edit).'<i class="icon-italic"></i>
		
		<a href="#MeuModal'.$id_ref.'" class="label label-danger" role="button" data-toggle="modal">Deletar</a>';

		echo "<tr class='gradeA'>";
     	echo "<td><center>$id_is</center></td>";
     	echo "<td><center>$u_insumo</center></td>";
     	echo "<td><center>$quantidade</center></td>";
     	echo "<td><center>$obs</center></td>";
     	echo "<td><center>$operacoes</center></td>";
		echo '<section id="MeuModal'.$id_ref.'" class="modal fade" tabindex="5" role="dialog" aria-labelledby="meuModelLabel" aria-hidden="true" style="display: none;">
				<div class="modal-dialog">
					<div class="modal-content">
						<header class="modal-header">
							<button class="close" data-dismiss="modal" aria-hidden="true">x</button>
							<h3 id="meuModelLabel">Realmente deseja excluir o insumo?</h3>
						</header>
						<section class="modal-body">
						</section>
						<footer class="modal-footer">
							<button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
							'.anchor("solicitacoes/deletarInsumo/$id_deletar",'Excluir',$anchor_delete).'
						</footer>
					</div>	
				</div>
			</section>';		
	}
	echo ' <div id="AddModal'.$id.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="meuModelLabel" aria-hidden="true" style="display: none;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
					<button class="close" data-dismiss="modal" aria-hidden="true">x</button>
					<legend>Preencha os dados do novo Insumo</legend>
				</div>
				<div class="modal-body">
					<div class="row-lg">
					<div class="col-lg-12">
						<fieldset>
							<div class="form-group">
								<form id="addInsumos" name="addInsumos" action="'.base_url().'solicitacoes/addInsumo" method="post" accept-charset="utf-8" class="form-horizontal control-group">
									<label class="col-tg-2 control-label">Insumo:</label>
									<div class="col-tg-4">
										<select class="input-large form-control" name="id_cad_insumos_cad_insumos" id="idcadinsumos" type="text" placeholder=".input-xxlarge">
											'.$all_insumos.'
										</select>
									</div>
									<label class="col-tg-2 control-label">Observação:</label>
									<div class="col-tg-4">
										<input name="observacao" id="observacao" type="text" class="form-control" name="observacao" value="">
									</div>
									<div class="col-tg-3"></div>
									<div class="col-tg-2">
										<input type="hidden" name="id_sol_insumos_solicitacao_insumos" value="'.$this->uri->segment(3).'" /><br />
										<input class="form-control btn btn-primary" type="submit" value="Adicionar"/>
									</div>
								</form>
							</div>
						</fieldset>
					</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
				</div>					
				</div>
			</div>
		</section>
		</div>';
?>
</tbody>
</table>
</div>
</div>

<?php
	// Botão voltar para tela anterior!	
	echo anchor('solicitacoes/colSolicitacao', 'VOLTAR', 'class="btn btn-primary"');

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
				"sLengthMenu": "Mostrar _MENU_ registros por página",
				"sZeroRecords": "Nenhum registro encontrado",
				"sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
				"sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
				"sInfoFiltered": "(filtrado de _MAX_ registros)",
				"sSearch": "Pesquisar: ",
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