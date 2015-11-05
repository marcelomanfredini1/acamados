<div class="span8 center bloco2 bs-docs-example">
<?php 
	if ($this->session->flashdata('excluirok')) {
		echo '<div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert">x</button>'. $this->session->flashdata('excluirok').'</div>';	
	}
	$tmpl = array (
                    'table_open'          => '<table class="table table-striped table-hover table-condensed">',

                    'heading_row_start'   => '<tr>',
                    'heading_row_end'     => '</tr>',
                    'heading_cell_start'  => '<th>',
                    'heading_cell_end'    => '</th>',

                    'row_start'           => '<tr class="info">',
                    'row_end'             => '</tr>',
                    'cell_start'          => '<td>',
                    'cell_end'            => '</td>',

                    'row_alt_start'       => '<tr>',
                    'row_alt_end'         => '</tr>',
                    'cell_alt_start'      => '<td>',
                    'cell_alt_end'        => '</td>',

                    'table_close'         => '</table>'
              );
    $this->table->set_template($tmpl);
	$this->table->set_heading(array('Nome','Entrada','Nascimento','Fone','UBS','Operações'));
	$anchor_delete = array('class'=>"btn  btn-danger");
	$anchor_edit = array('class'=>"label label-warning");
	foreach ($pacientes as $linha) {
		foreach($ubs -> result() as $unidade) {
			if ($unidade->id_unidade == $linha->id_unidade){
				$u_user = $unidade->nome_unidade;
			}
		}
		$fDateEntr = date("d-m-Y", strtotime($linha->dt_entrada));
		$fDateNasc = date("d-m-Y", strtotime($linha->dt_nascimento));
		$this->table->add_row($linha->nome_paciente,$fDateEntr,$fDateNasc,$linha->fone,$u_user,anchor("pacientes/editar/$linha->id_cad_pacientes",'Editar',$anchor_edit).' <i class="icon-italic"></i> <a href="#MeuModal'.$linha->id_cad_pacientes.'" class="label label-important" role="button" data-toggle="modal">Deletar</a>');
		echo '<section id="MeuModal'.$linha->id_cad_pacientes.'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="meuModelLabel" aria-hidden="true" style="display: none;">
						<header class="modal-header">
							<button class="close" data-dismiss="modal" aria-hidden="true">x</button>
							<h3 id="meuModelLabel">Realmente deseja Excluir o usuario?</h3>
						</header>
						<section class="modal-body">
						</section>
						<footer class="modal-footer">
							<button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
							'.anchor("pacientes/deletar/$linha->id_cad_pacientes",'Excluir',$anchor_delete).'
						</footer>
					</section>';
	}	
	echo $this->table->generate();
	if ($paginacao) {
		echo '<div class="pagination pagination-centered">';
		echo $paginacao;
		echo "</div>";
	}
?>
</div>