<div class="col-lg-10 center">
	<div class="well bs-docs-example">
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
				<th class="span3">Nome</th>
				<th class="span3">CNS</th>
				<th class="span2">Entrada</th>
				<th class="span2">Nascimento</th>
				<th class="span2">Fone</th>
				<th class="span3" >UBS</th>
				<th class="span2">Insumos</th>
			</tr>
		</thead>
	<tbody>
<?php
	foreach ($pacientes as $linha)
	{
		$u_user = $linha->nome_unidade;
		$fDateEntr = date("d-m-Y", strtotime($linha->dt_entrada));
		$fDateNasc = date("d-m-Y", strtotime($linha->dt_nascimento));
		$nome = $linha->nome_paciente;
		$cns = $linha->cns;
		$entrada = $fDateEntr;
		$telefone = $linha->fone;
		$operacoes = anchor("solicitacoes/solicitacao_insumos/$linha->id_cad_pacientes",'Incluir Insumos',$anchor_edit).' <i class="icon-italic"></i>';
		echo "<tr class='gradeA'>";
        echo "<td><center><font face='helvetica' font size='2'>$nome</font></center></td>";
        echo "<td><center><font face='helvetica' font size='2'>$cns</font></center></td>";
        echo "<td><center><font face='helvetica' font size='2'>$entrada</font></center></td>";
        echo "<td><center><font face='helvetica' font size='2'>$fDateNasc</font></center></td>";
        echo "<td><center><font face='helvetica' font size='2'>$telefone</font></center></td>";
		echo "<td><center><font face='helvetica' font size='2'>$u_user</font></center></td>";
		echo "<td><center><font face='helvetica' font size='2'>$operacoes</font></center></td>";
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
					"sTitle": "Usuarios",
					"mColumns": [0, 1, 2, 3, 4]
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
});//fim jquery
</script>



	</div>
</div>