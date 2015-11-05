<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<meta name="description" content="Sistema de Acamados"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<link rel="shortcut icon" href="<?php echo base_url(); ?>padrao/img/favicon.ico"/>
	<title>
	<?php 
		if(!isset($title))
		{
			echo $titulo;
		}else{
			echo $title;
		}
	?></title>
	<!-- Ajustes para layout responsivo
		jquery.dataTables_themeroller
	<script type="text/javascript" src="<?php echo base_url(); ?>padrao/js/jquery.min.js" ></script>
		 -->

	<!--[if lte IE 9]>
	  <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
	  <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.3.0/respond.js"></script>
	<![endif]--> 
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- Link's para CSS -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>padrao/css/bootstrap-material.min.css" media="screen" type="text/css"/>
		<link rel="stylesheet" href="<?php echo base_url(); ?>/padrao/datatables/extensions/TableTools/css/dataTables.tableTools.min.css" type="text/css"/>
		<link rel="stylesheet" href="<?php echo base_url(); ?>padrao/css/jquery.dataTables.min.css" type="text/css"/>
		<link rel="stylesheet" href="<?php echo base_url(); ?>padrao/css/jquery.dataTables_themeroller.css" type="text/css"/>
		<link rel="stylesheet" href="<?php echo base_url(); ?>padrao/css/bootstrap-multiselect.css" type="text/css"/>
		<link href="<?php echo base_url(); ?>padrao/css/estilo.css" rel="stylesheet">
	
	<!-- Link's para JS -->
		<script type="text/javascript" src="<?php echo base_url(); ?>padrao/js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>padrao/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>padrao/js/bootstrap-3.1.1.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>padrao/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
	 	<script type="text/javascript" src="<?php echo base_url(); ?>padrao/js/bootstrap-multiselect.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>padrao/js/maskedinput.js"></script>

</head>
<body>
<!--Barra superior fixa-->
	<div class="navbar navbar-fixed-top navbar-inverse">
				<!-- essa classe é usada como aldenador para o conteudo colapsavel -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-inverse-collapse">
			      <span class="icon-bar"></span>
			      <span class="icon-bar"></span>
			      <span class="icon-bar"></span>
			    </button>
			    <a class="navbar-brand" href=<?php echo base_url(); ?>>Acamados</a>
			</div>
				<!--Tudo que for escondido a menos de 940px-->
				<div class="navbar-collapse collapse navbar-inverse-collapse">
					<ul class="nav navbar-nav">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Paciêntes
							<b class="caret"></b></a> <!--Seta de expansão-->
							<ul class="dropdown-menu">
								<li>
									<a href="<?php echo base_url('pacientes/newPaciente'); ?>">Cadastrar</a>
								</li>
								<li>
									<a href="<?php echo base_url('pacientes/colPaciente'); ?>">Consultar Pacientes</a>
								</li>
							</ul>
						</li>
						<li class=" dropdown">
						<a href="" class="dropdown-toggle" data-toggle="dropdown">
							Insumos
							<b class="caret"></b></a> <!--Seta de expansão-->
												
							<ul class="dropdown-menu">
								<li><a href="<?php echo base_url('insumos/newInsumos')?>">Cadastro</a></li>
								<li><a href="<?php echo base_url('insumos/colInsumos')?>">Consultar/Alterar</a></li>
							</ul>

						</li>

						<li class="dropdown">
						<a href="" class="dropdown-toggle" data-toggle="dropdown">
							Solicitações
							<b class="caret"></b></a> <!--Seta de expansão-->
												
							<ul class="dropdown-menu">
							<li><a href="<?php echo base_url('solicitacoes/novasolicitacao')?>">Cadastro (PROVISÓRIO)</a></li>
								<!--<li><a href="<?php// echo base_url('solicitacoes/newSolicitacao')?>">Cadastro (EM MANUTENÇÃO)</a></li>-->
								<li><a href="<?php echo base_url('solicitacoes/view_new_solicitacao')?>">Cadastro Insumo por paciente(EM MANUTENÇÃO)</a></li>
								<li><a href="<?php echo base_url('solicitacoes/colSolicitacao')?>">Consultar/Alterar</a></li>
								<li><a href="<?php echo base_url('solicitacoes/avSolicitacao')?>">Avaliação Tecnica</a></li>
							</ul>

						</li>

						<li class="dropdown">
						<a href="" class="dropdown-toggle" data-toggle="dropdown">
							Relatório
							<b class="caret"></b></a> <!--Seta de expansão-->
												
							<ul class="dropdown-menu">
								<li><a href="<?php echo base_url('relatorio/geral')?>">Todos</a></li>
								<li><a href="<?php echo base_url('relatorio/insporuni')?>">Solicitações por unidade</a></li>
								<li><a href="<?php echo base_url('relatorio/solRegiao')?>">Solicitações por região</a></li>
							</ul>

						</li>
						</ul>
						<ul class="nav navbar-nav navbar-right">
						<li>
							<a href="<?php echo base_url('login/asenha');?>">ALTERAR SENHA</a>
						</li>

						<li>
							<a href="<?php echo base_url('login/logoff');?>">SAIR &nbsp&nbsp&nbsp</a>
						</li>
						</ul>
				</div>
			</div>
		</div>
	<!-- Cabeçalho -->
		<!--Cabeçalho copiado da Globo Bootstrap-->
	<header class="jumbotron subhead" id="overview">
		<div class="container">
			<br /><br />
			<h2 style="text-align:center; text-shadow: 3px  3px 5px black;"> 
				<font color ="ffffff">SISTEMA DE CONTROLE DO ATENDIMENTO DOMICILIAR</font>
			</h2>
		</div>
	</header>
	<body>
<div class="row">
	<div class="col-lg-1"></div>