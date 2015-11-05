<div class="col-lg-10 center">
	<div class="well bs-component">
<form action="<?php echo base_url(); ?>solicitacoes/armazenar_Solicitacao" class="form-horizontal" method="POST">
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
	'<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert">x</button>'. $this->session->flashdata('edicaook').'</div>';	
	}
	if ($this->session->flashdata('alert')) {
	'<div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert">x</button>'. $this->session->flashdata('excluirok').'</div>';	
	}
	if ($this->session->flashdata('adcOk')) {
		echo $this->session->flashdata('adcOk');	
	}
	echo '
	<div class="control-group">
		<label class="col-lg-2 control-label" for="paciente"><font face="helvetica" font size="2">Paciente</font></label>
			<div class="col-lg-10">
				<input class="input-xxlarge form-control" id="idPaciente" pac="'.$paciente->row()->id_cad_pacientes.'" value="'.$paciente->row()->paciente.'" disabled>
			</div>
		<label class="col-lg-2 control-label"><font face="helvetica" font size="2">UBS:</font></label>
			<div class="col-lg-10">
				<input class="input-xxlarge form-control" value="'.$paciente->row()->unidade.'" disabled>
			</div>
		<label class="col-lg-2 control-label"><font face="helvetica" font size="2">Tipo Solicitação:</font></label>
			<div class="col-lg-4">
				<select class="input-xxlarge form-control" name="id_tipo_solicitacao_tipo_solicitacao" readonly>
				<option value="1">Solicitação</option>
				</select>
			</div>
	
		<div class="col-lg-5">
			<a href="#modal" class="btn btn-info" type="button" role="button" data-toggle="modal">Novo Insumo</a>
		</div>
	</div> 
	</div>
	';
	$anchor_edit = array('class'=>"label label-warning");
	anchor("solicitacoes/editarInsumos/",'Editar Insumos Solicitados',$anchor_edit);

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
				<th class="span2">Deletar</th>
			</tr>
		</thead>
		<tbody>

		<tr id="removerLinha">
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>

		</tbody>
	</table>
</div>
</div>

<div style="border: solid; width: 100px;">
	
</div>

<?php
	// Botão voltar para tela anterior!	
	echo anchor('solicitacoes/view_new_solicitacao', 'VOLTAR', 'class="btn btn-primary"');
	echo anchor('solicitacoes/armazenar_Solicitacao', 'Gravar', 'class="btn btn-success pull-right" id="enviar"');

?>

</div>

<!--Modal Inicio -->
<section id="modal" class="modal fade" tabindex="5" role="dialog" aria-labelledby="meuModelLabel" aria-hidden="true" style="display: none;">
<div class="modal-dialog">
	<div class="modal-content">
		<header class="modal-header">
			<button class="close" data-dismiss="modal" aria-hidden="true">x</button>
			<h3 id="meuModelLabel">Adicionar Insumo!</h3>
		</header>
		<section class="modal-body">

<div class="form-group">
	
		
		<select class="input-xxlarge form-control" id="insumo" >
			<option>Selecione...</option>
			<?php 

				foreach ($insumos as $insumo) {
					echo '<option id="qtdvalor"  value="'.$insumo->id_cad_insumos.'" qtd="'.$insumo->quantidade.'">'.$insumo->nome_insumo.' Cota: '.$insumo->quantidade.'</option>';
				}

			 ?>
		</select>
		Quantidade: <input class="input-xxlarge form-control" id="quantidade" type="text">
		Status: <select class="input-xxlarge form-control" id="status" disabled>
		<option value="Fila de Espera">Fila de Espera</option>
		<!--
			<option value="Liberado">Fila de Liberado</option>
			<option value="Inativo">Inativo</option> 
		-->
		</select>
		Observação: <input class="input-xxlarge form-control" type="text" id="observacao">
		<input type="button" value="Adicionar a lista" class="form-control col-lg-2 btn btn-primary add" data-dismiss="modal" aria-hidden="true"></br>
	
</div>
</section>
			<footer class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
			</footer>
		</div>	
	</div>
</section>	
</form>
<script>
	//Todos scripts dentro de Document.Ready são Jquery 
	$(document).ready(function() {

		//Autopreenchimento do campo quantidade.
		$('#insumo').change(function(){
			//Inserir quantidade.
			$('#quantidade').val($("#insumo option:selected").attr('qtd'));

		});

		var arrayIdInsumos = [];
		//Adiciona o insumo no array, cria uma linha na tabela.
		$('.add').click(function(){

			$('#removerLinha').remove();
			
			if ($("#insumo option:selected").text() != "Selecione..." &&
				$('#quantidade').val() != '' &&
				$("#observacao").val() != '') { //Validar campos preenchidos.

				arrayIdInsumos[arrayIdInsumos.length] = $("#insumo").val();

				var linha 	   = '<tr class="deletarLinha" id="id'+$("#insumo").val()+'">';
				var ID 	       = "<td class=\"idInsumo\"><input type=\"hidden\" name=\"idInsumo[]\" value=\""+$("#insumo").val()+"\" readonly>"+$("#insumo").val()+"</td>";
				var Insumo     = "<td class=\"nomeInsumo\">"+$("#insumo option:selected").text()+"</td>";
				var Quantidade = "<td class=\"quantidadeInsumo\"><input name=\"quantidadeInsumo[]\" value=\""+$('#quantidade').val()+"\"></td>";
				var Status     = "<td class=\"statusInsumo\"><input type=\"hidden\" name=\"statusInsumo[]\" value=\""+$("#status").val()+"\" readonly>"+$("#status").val()+"</td>";
				var Observacao = "<td class=\"obsInsumo\"><input name=\"obsInsumo[]\" value=\""+$('#observacao').val()+"\"></td>";
				var Deletar    = "<td><button class=\"btn btn-danger\" on=\"id"+$("#insumo").val()+"\" >deletar</button></td>";

				linha += ID + Insumo + Quantidade + Status + Observacao + Deletar + "</tr>"
				$('#consultar_usuarios').append(linha);

				$('#insumo option[value="'+$("#insumo").val()+'"]').remove();

				$('#quantidade').val("");
				$('#observacao').val("");

			} else {
				alert('Todos campos são obrigatórios!');
				return false;
			}

		});

		//Remove a linha
		$('table').on('click','button',function(e){
			
			$("#"+$(this).attr('on')).remove();

			for (var i = 0; i < arrayIdInsumos.length; i++) {
				//Como o valor do attr('on') tem um id fixo no texto inicial, adicionamos um id no vetor temporariamente para comparar.
				var valor = "id" + arrayIdInsumos[i];
				if(valor == $(this).attr('on')) {
					arrayIdInsumos.splice(i, 1);
				}

			};

		});

		//tratamento antes de enviar para o controller.
		$("#enviar").click(function(e){

			 e.preventDefault();
			$('form').submit();


		});

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
	});//fim jquery
	
</script>
