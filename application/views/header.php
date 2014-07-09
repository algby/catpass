<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="HipsterCat">
		<title>CatPass</title>
		<!-- Bootstrap core CSS -->
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?=base_url()?>css/style.css">
		<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/zeroclipboard/2.1.5/ZeroClipboard.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
		<script src="<?=base_url()?>static/js/main.js"></script>
		
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Basculer</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?=base_url()?>">CatPass (0.1)</a>
				</div>
				<div class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<?php if($email) { ?>
						<li><a href="<?=base_url()?>passwords"> Mes mots de passe</a></li>
						<li><a href="<?=base_url()?>keepass"> Importer un fichier KeePass</a></li>
						<?php } else { ?>
						<li><a href="<?=base_url()?>register">S'inscrire</a></li>
						<?php } ?>
						<li><a href="<?=base_url()?>secure">Sécurité</a></li>
						<li><a href="#contact">Contact</a></li>
					</ul>
					<?php if($email) { ?>
						<p class="navbar-right navbar-text">Bonjour, <?=$email?> - <a href="<?=base_url()?>logout">Se déconnecter</a></p>
					<?php } else { ?>
					<form class="navbar-form navbar-right" role="form" method="post" action="<?=base_url()?>login">
						<div class="form-group">
							<input type="email" name="email" placeholder="Email" class="form-control">
						</div>
						<div class="form-group">
							<input type="password" name="password" placeholder="Password" class="form-control">
						</div>
						<button type="submit" class="btn btn-success">Se connecter</button>
					</form>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="container">