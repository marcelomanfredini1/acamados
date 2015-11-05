	<!DOCTYPE html>
	<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
	<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
	<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
	<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->

	<!-- Link's para CSS e JS-->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="<?php echo base_url(); ?>padrao/js/jquery-2.1.1.min.js"><\/script>')</script>
	<link href="<?php echo base_url(); ?>padrao/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>padrao/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>padrao/css/estilo.css" rel="stylesheet">
	<script src="<?php echo base_url(); ?>padrao/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>padrao/js/maskedinput.js" type="text/javascript"></script>
	<link href="<?php echo base_url(); ?>padrao/css/style.css" rel="stylesheet">
	
	<!-- Ajustes para layout responsivo -->
	<meta charset="UTF-8"/>
	<meta name="description" content=""/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Acamados</title>
  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>
  <section class="container">
    <div class="login">
      <h1>Acamados - Login</h1>
			      <?php 
			      		$atriForm = array('class' => 'form',);
			      		echo form_open('login/Validar', $atriForm);
				  		echo validation_errors('<div class="alert alert-block alert-error"><button type="button" class="close" data-dismiss="alert">x</button>','</div>');
						echo form_label('<font face="helvetica" font size="2">Nome de Usuario:</font>');
						echo form_input(array('name' => 'nome'),set_value('nome'),'autofocus');
						echo form_label('<font face="helvetica" font size="2">Senha:</font>');
						echo form_password(array('name' => 'senha'),set_value('senha'));
						echo form_submit(array('name' => 'logar', 'class' => 'btn btn-primary'), 'Logar');
					?>
    </div>

    <section class="about">
       <p class="about-author">
      <p>&copy; 2014 DTTICS - Secretaria da Saúde de Guarulhos</p><br>
  </section>

   </body>
</html>