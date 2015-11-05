<div class="col-lg-10 center" align="center">
	<div class="well bs-component">

	<?php echo validation_errors('<div class="alert alert-dismissable alert-danger"><button type="button" class="close" data-dismiss="alert">x</button>','</div>');
		if ($this->session->userdata('aviso')) {
			echo '<p>'. $this->session->userdata('aviso').'</p>';
			$this->session->set_userdata('aviso',null);	
		}  ?>

	<?php echo form_open('solicitacoes/nosolicitacao');
	echo form_fieldset('Nova Solicitação Para:');?>

		<select name="id">


			<?php 

			echo'<option>SELECIONE</option>';

			foreach($paciente as $nome) {

				echo'<option> UBS - '.$nome->nome_unidade.' / PACIENTE - '.strtoupper($nome->nome_paciente).' id#'.$nome->id_cad_pacientes.'</option>';

			} ?>

		</select>
		<br> <br>

	<?php echo form_submit('enviar','Confirmar','class="btn btn-success" align="center"');
	echo form_fieldset_close('');
	echo form_close(); ?>
		

	</div>
</div>