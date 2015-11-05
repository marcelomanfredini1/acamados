<div class="col-lg-10 center">
	<div class="well bs-component">
<?php 
	if ($this->session->flashdata('excluirok')) {
		echo '<div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert">x</button>'. $this->session->flashdata('excluirok').'</div>';	
	}
?>
<div id="tabs-1">
	<table class="display table table-striped table-hover table-condensed" id="consultar_usuarios">
		<thead> 
			<tr>
				<th class="span3">Codigo</th>
				<th class="span3">Insumo</th>
				<th class="span2">Unidade de Medida</th>
				<th class="span2">Quantidade</th>
				<th class="span2">Periodo de Cota(em dias)</th>
				<th class="span3" >Operações</th>
			</tr>
		</thead>
	<tbody>
<?php
	$anchor_delete = array('class'=>"btn  btn-danger");
	$anchor_edit = array('class'=>"label label-warning");
	foreach ($insumos as $linha) {
		$codigo = $linha->codigo;
		$udm_insumo = $linha->nome;
		$nome_insumo = $linha->nome_insumo;
		$quantidade = $linha->quantidade;
		$periodo_dias = $linha->periodo_dias;
		$operacoes = anchor("insumos/editar/$linha->id_cad_insumos",'Editar',$anchor_edit).' <i class="icon-italic"></i> <a href="#MeuModal'.$linha->id_cad_insumos.'" class="label  label-danger" data-toggle="modal">Deletar</a>';
		echo "<tr class='gradeA'>";
        echo "<td><center><font face='helvetica' font size='2'>$codigo</font></center></td>";
        echo "<td><center><font face='helvetica' font size='2'>$nome_insumo</font></center></td>";
        echo "<td><center><font face='helvetica' font size='2'>$udm_insumo</font></center></td>";
        echo "<td><center><font face='helvetica' font size='2'>$quantidade</font></center></td>";
        echo "<td><center><font face='helvetica' font size='2'>$periodo_dias</font></center></td>";
		echo "<td><center><font face='helvetica' font size='2'>$operacoes</font></center></td>";
		echo '<div id="MeuModal'.$linha->id_cad_insumos.'" class="modal fade" aria-hidden="true" style="display: none;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button class="close" data-dismiss="modal" aria-hidden="true">x</button>
						<h3 id="meuModelLabel">Realmente deseja Excluir o usuario?</h3>
					</div>
					<div class="modal-footer">
						<button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
						'.anchor("insumos/deletar/$linha->id_cad_insumos",'Excluir',$anchor_delete).'
						</div>					
				</div>
			</div>
		</section>
		</div>';
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
			"sSwfPath": "/padrao/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
			"aButtons": [ 
				{ 
					"sExtends": "xls",
					"sButtonText": "Exportar para Excel",
					"sTitle": "Insumos Cadastrados",
					"mColumns": [0, 1, 2, 3, 4]
				},
				{
					"sExtends": "pdf",
					"sButtonText": "Exportar para PDF",
					"sTitle": "Insumos Cadastrados",
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
