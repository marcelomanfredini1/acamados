<div class="col-lg-10 center">
	<div class="well bs-component">
		<div id="tabs-1">
	<table class="display table table-striped table-hover table-condensed" id="consultar_usuarios">
		<thead> 
			<tr>
				<th class="span3">Unidade</th>
				<th class="span3">Paciente</th>
				<th class="span2">Status</th>
				<th class="span2">Tipo</th>
				<th class="span2">Operações</th>
			</tr>
		</thead>
	<tbody>
<?php
	$anchor_edit = array('class'=>"label label-primary");
	foreach ($resultado as $solicitacao)
	{
		
		$operacoes = anchor("Relatorio/unidade/$solicitacao->id",'Vizualizar',$anchor_edit);
		 $unidade = $solicitacao->nome_unidade;
		 $nome = $solicitacao->nome_paciente;
		 $status = $solicitacao->status;
		 $tipo = $solicitacao->tipo;
		 echo "<tr class='gradeA'>";
	     echo "<td><center>$unidade</center></td>";
	     echo "<td><center>$nome</center></td>";
	     echo "<td><center>$status</center></td>";
	     echo "<td><center>$tipo</center></td>";
	     echo "<td><center>$operacoes</center></td>";
		echo "</tr>"; 
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
			"sSwfPath": "/padrao/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
			"aButtons": [ 
				{ 
					"sExtends": "xls",
					"sButtonText": "Exportar para Excel",
					"sTitle": "Solicitacoes por Unidade",
					"mColumns": [0, 1, 2]
				},
				{
					"sExtends": "pdf",
					"sButtonText": "Exportar para PDF",
					"sTitle": "Solicitacoes por Unidade",
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
});//fim jquery
</script>