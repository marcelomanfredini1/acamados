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
		<label class="col-lg-2 control-label" for="paciente"><font face="helvetica" font size="2">Paciente</font></label>
			<div class="col-lg-10">
				<select class="input-xxlarge form-control" name="id_cad_pacientes_cad_pacientes" id="paciente" type="text" placeholder=".input-xxlarge" readonly disabled>
					'.$pacientes.'
				</select>
			</div>
		<label class="col-lg-2 control-label"><font face="helvetica" font size="2">UBS:</font></label>
			<div class="col-lg-10">
				<select class="input-xxlarge form-control" name="id_unidade" id="ubs" type="text" placeholder=".input-xxlarge" readonly disabled>
					'.$ubs.'
				</select>
			</div>
		<label class="col-lg-2 control-label"><font face="helvetica" font size="2">Tipo Solicitação:</font></label>
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
	$anchor_edit = array('class'=>"label label-warning");
	anchor("solicitacoes/editarInsumos/$id",'Editar Insumos Solicitados',$anchor_edit);
	//print_r($insumos);

	$anchor_delete = array('class'=>"btn  btn-danger");
	$anchor_edit = array('class'=>"label label-warning");
	$anchor_add = array('class'=>"btn btn-primary");
?>
<div id="tabs-1">
	<table class="display table table-striped table-hover table-condensed" id="consultar_usuarios">
		<thead> 
			<tr>
				<th class="span2">ID</th>
				<th class="span2">Insumo</th>
				<th class="span2">Quantidade</th>
				<th class="span2">Status</th>
				<th class="span2">Observação</th>
				<th class="span2">Operações</th>
			</tr>
		</thead>
	<tbody>
<?php 
	$i=1;
	foreach ($insumos as $insumo) {
		$id_is = $i++;
		$u_insumo = $insumo->nome_insumo;
		$quantidade = $insumo->quantidade;
		$obs = $insumo->observacao;
		//$stat = ;
		$id_ref=$insumo->id_cad_insumos_cad_insumos.'-'.$insumo->id_sol_insumos_solicitacao_insumos;
		$id_deletar=$insumo->id_cad_insumos_cad_insumos.'/'.$insumo->id_sol_insumos_solicitacao_insumos;
		$operacoes = '<a href="#MeuModal'.$id_ref.'" class="label label-danger" role="button" data-toggle="modal">Avaliar</a>';

		echo "<tr class='gradeA'>";
     	echo "<td><center>$id_is</center></td>";
     	echo "<td><center>$u_insumo</center></td>";
     	echo "<td><center>$quantidade</center></td>";
     	echo "<td><center>$insumo->status</center></td>";
     	echo "<td><center>$obs</center></td>";
     	echo "<td><center>$operacoes</center></td>";
		echo '<section id="MeuModal'.$id_ref.'" class="modal fade" tabindex="5" role="dialog" aria-labelledby="meuModelLabel" aria-hidden="true" style="display: none;">
				<div class="modal-dialog">
					<div class="modal-content">
						<header class="modal-header">
							<button class="close" data-dismiss="modal" aria-hidden="true">x</button>
							<h3 id="meuModelLabel">Avaliar_2</h3>
						</header>
						<section class="modal-body">';
		echo '
			<div class="form-group">
				<form action="'.base_url().'solicitacoes/avaliar/'.$id_ref.'/1/" class="form-horizontal" method="POST">
					<label for="status" class="col-lg-2 control-label"><font face="helvetica" font size="2">Status:</font></label>
					<select name="status" id="status" class="col-lg-4 form-control">
						<option value="Deferido">Deferido</option>
						<option value="Indeferido">Indeferido</option>
						<option value="Em Analise">Em Analise</option>
					</select>
					<label for="observacao" class="col-lg-2 control-label"><font face="helvetica" font size="2">Observação:</font></label>
					<input type="text" name="observacao"  class="col-lg-4 form-control observacao"></br>
					<input type="submit"   value="btn_avaliar" class="form-control col-lg-2 btn btn-primary btn_avaliar"></br>
				</form>
			</div>
			</br></br></br></br></br>
			
		';
		echo '</section>
						<footer class="modal-footer">
							<button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
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
		$('#consultar_usuarios').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"sDom": '<"H"Tlfr>t<"F"ip>',
			"oTableTools": {
				"sSwfPath": "<?php echo base_url(); ?>/padrao/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
				"aButtons": [ 
					{ 
						"sExtends": "xls",
						"sButtonText": "Exportar para Excel",
						"sTitle": "Usuarios",
						"mColumns": [0, 1, 2]
					},
					{
						"sExtends": "pdf",
						"sButtonText": "Exportar para PDF",
						"sTitle": "Usuarios",
						"sPdfOrientation": "landscape",
						"mColumns": [0, 1, 2, 3, 4] 
					} 
				] 
			},
			"oLanguage": {
				"sLengthMenu": "<font face='helvetica' font size='2'>Mostrar _MENU_ registros por página</font>",
				"sZeroRecords": "Nenhum registro encontrado",
				"sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
				"sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
				"sInfoFiltered": "(filtrado de _MAX_ registros)",
				"sSearch": "<font face='helvetica' font size='2'>Pesquisar: </font>",
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
	
	$(".btn_avaliar").attr("disabled","disabled");
	$(".observacao").keyup(function(){
		if($(this).val()!=""){
		 	$(".btn_avaliar").removeAttr("disabled");	
		}
		else{
			$(".btn_avaliar").attr("disabled","disabled");
		}


	});	

	});//fim jquery
	
</script>
