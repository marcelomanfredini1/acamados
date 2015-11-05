<div class="col-lg-10 center">
	<div class="well bs-docs-example">
<?php 
	if ($this->session->userdata('aviso')) {
		echo '<div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert">x</button>'. $this->session->userdata('aviso').'</div>';	
		$this->session->set_userdata('aviso',null);
	}
	$anchor_delete = array('class'=>"btn  btn-danger");
	$anchor_edit = array('class'=>"label label-success");
?>
<div id="tabs-1">
	<table class="display table table-striped table-hover table-condensed" id="consultar_usuarios">
		<thead> 
			<tr>
				<th class="span3">Nome</th>
				<th class="span2">Entrada</th>
				<th class="span2">Nascimento</th>
				<th class="span2">Fone</th>
				<th class="span3" >UBS</th>
				<th class="span2">Solicitar</th>
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
		$entrada = $fDateEntr;
		$telefone = $linha->fone;
		//$u_user,
		$operacoes = anchor("solicitacoes/solicitar/$linha->id_cad_pacientes",'SOLICITAR',$anchor_edit);
		echo "<tr class='gradeA'>";
        echo "<td><center><font face='helvetica' font size='2'>$nome</font></center></td>";
        echo "<td><center><font face='helvetica' font size='2'>$entrada</font></center></td>";
        echo "<td><center><font face='helvetica' font size='2'>$fDateNasc</font></center></td>";
        echo "<td><center><font face='helvetica' font size='2'>$telefone</font></center></td>";
		echo "<td><center><font face='helvetica' font size='2'>$u_user</font></center></td>";
		echo "<td><center><font face='helvetica' font size='2'>$operacoes</font></center></td>";
		echo '
		<div id="MeuModal'.$linha->id_cad_pacientes.'" class="modal fade" aria-hidden="true" style="display: none;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button class="close" data-dismiss="modal" aria-hidden="true">x</button>
						<h3 id="meuModelLabel">Realmente deseja Excluir o usuario?</h3>
					</div>
					<div class="modal-footer">
						<button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
						'.anchor("pacientes/deletar/$linha->id_cad_pacientes",'Excluir',$anchor_delete).'
					</div>					
				</div>
			</div>
		</section>
		</div>';
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
			"sSwfPath": "/acamados/padrao/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
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
