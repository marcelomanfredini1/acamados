<div class="col-lg-10 center">
	<div class="well bs-component">
		<form action="<?php echo base_url('relatorio/regiao'); ?>" class="form-horizontal" method="POST">
			<fieldset>
				<div class="form-group">
					<label for="ubs" class="col-lg-2 control-label">Escolha a Região de Saude:</label>
					<div class="col-lg-10">
						<select class="input-xlarge form-control" name="id_regiao" id="ubs" type="text" placeholder=".input-xxlarge">
							<?php echo ($options);?>
						</select><br /><br />
						<input type="submit" name="consultar" value="Consultar" class="col-lg-2 btn btn-primary aling-center form-control">
					</div>
				</div>
			</fieldset>
		
		</form>
	</div>
</div>