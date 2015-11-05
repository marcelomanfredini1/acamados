<div class="col-lg-10 center" align="center">
	<div class="well bs-docs-example" align="center">

	<?php 
	if ($this->session->userdata('aviso')) {
		echo '<div class="alert alert-block alert-warning"><button type="button" class="close" data-dismiss="alert">x</button>'. $this->session->userdata('aviso').'</div>';
		$this->session->set_userdata('aviso',null);	
	} ?>

	<?php echo form_open("login/senha") ?>

	<?php echo form_fieldset("Alteração de senha") ?>

	<input type="password" id="formulariosimples" name="senha" placeholder="Nova Senha"/ autofocus> <br>

	<input type="password" id="formulariosimples" name="senha2" placeholder="Confirme a nova Senha"/> <br>

	<?php echo form_submit(array('name'=>'cadastrar2'),'Confirmar', 'class="btn btn-primary" id="button"'); ?></td>

	<?php echo form_fieldset_close() ?>

	<?php echo form_close() ?>

	</div>
</div>