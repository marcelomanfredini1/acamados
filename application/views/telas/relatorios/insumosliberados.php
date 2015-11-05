<div class="col-lg-10 center">
	<div class="well bs-component">
<?php 
	if ($this->session->flashdata('excluirok')) {
		echo '<div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert">x</button>'. $this->session->flashdata('excluirok').'</div>';	
	}
	$anchor_delete = array('class'=>"btn  btn-danger");
	$anchor_edit = array('class'=>"label label-warning");
?>
<div id="tabs-1">
	<table class="display table table-striped table-hover table-condensed" id="consultar_usuarios">
		<thead> 
			<tr>
				<th class="span3">UBS</th>
				<th class="span2">Paciente</th>
				<th class="span2">Solicitação</th>
				<th class="span2">Insumo</th>
				<th class="span2">Status</th>
				<th class="span2">Liberado em:</th>
			</tr>
		</thead>
	<tbody>
<?php

	/*
		'solicitacoes' => $solicitacoes,
		'ubs' => $pac_ubs,
		'nomes' => $pac_nomes,
		'tipos' => $arrayTipos,
	*/
		
 foreach ($query as $row) {
     $unidade = $row->nome_unidade;
	 $paciente = $row->nome_paciente;
	 $solicitacao = $row->id_sol_insumos;
	 $insumo = $row->nome_insumo;
	 $status = $row->status;
	 $liberadoem = $row->data_liberacao;

	 echo "<tr class='gradeA'>";
     echo "<td><center>$unidade</center></td>";
     echo "<td><center>$paciente</center></td>";
     echo "<td><center>$solicitacao</center></td>";
     echo "<td><center>$insumo</center></td>";
     echo "<td><center>$status</center></td>";
     echo "<td><center>$liberadoem</center></td>";
 }
?>
</tbody>
</table>
</div>
</div>
<script>
	//Todos scripts dentro de Document.Ready são Jquery 
	$(document).ready(function() {
		$('#consultar_usuarios').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"sDom": '<"H"Tlfr>t<"F"ip>',
			"oTableTools": {
				"sSwfPath": "/acamados/padrao/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
				"aButtons": [ 
					{ 
						"sExtends": "xls",
						"sButtonText": "Exportar para Excel",
						"sTitle": "Solicitações",
						"mColumns": [0, 1, 2, 3, 4]
					},
					{
						"sExtends": "pdf",
						"sButtonText": "Exportar para PDF",
						"sTitle": "Solicitações",
						"sPdfOrientation": "landscape",
						"mColumns": [0, 1, 2] 
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