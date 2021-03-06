<div class="col-lg-10 center">
	<div class="well bs-component">
<?php 
	if ($this->session->flashdata('excluirok')) {
		echo '<div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert">x</button>'. $this->session->flashdata('excluirok').'</div>';	
	}
	$anchor_av = array('class'=>"btn  btn-primary");
?>
<div id="tabs-1">
	<table class="display table table-striped table-hover table-condensed" id="consultar_usuarios">
		<thead> 
			<tr>
				<th class="span3">Paciente</th>
				<th class="span2">Unidade</th>
				<th class="span2">Tipo</th>
				<th class="span2">Status</th>
				<th class="span2">Operações</th>
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
		
	 foreach ($solicitacoes as $solicitacao) {
	     $unidade = $solicitacao->nome_unidade;
		 $nome = $solicitacao->nome_paciente;
		 $tipo = $solicitacao->tipo;
		 $status = $solicitacao->status;
		 $operacoes = anchor("solicitacoes/avaliar/$solicitacao->id",'Avaliar',$anchor_av);	
		 $operacoes2 = anchor("solicitacoes/avaliar/$solicitacao->id",'Avaliar2',$anchor_av);	
		 echo "<tr class='gradeA'>";
	     echo "<td><center><font face='helvetica' font size='2'>$nome</font></center></td>";
	     echo "<td><center><font face='helvetica' font size='2'>$unidade</font></center></td>";
	     echo "<td><center><font face='helvetica' font size='2'>$tipo</font></center></td>";
	     echo "<td><center><font face='helvetica' font size='2'>$status</font></center></td>";
	     echo "<td><center><font face='helvetica' font size='2'>$operacoes</font></center></td>";
	     echo "<td><center><font face='helvetica' font size='2'>$operacoes2</font></center></td>";
	 }
	?>
</tbody>
</table>
</div>
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
	})
	;//fim jquery
</script>