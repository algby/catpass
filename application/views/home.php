		<div class="starter-template">
			<?= isset($success) ? "<div class=\"alert alert-success\"><span class=\"glyphicon glyphicon-ok\"></span> ".$success."</div>" : ""?>
			<?= isset($error) ? "<div class=\"alert alert-danger\"><span class=\"glyphicon glyphicon-remove\"></span> ".$error."</div>" : ""?>
			<h1>CatPass</h1>
			<p class="lead">
				CatPass est un gestionnaire de mots de passe. Il vous permet de générer des mots de passe et de les stocker de façon sécurisée. CatPass est basé sur KeePass et permet même d'importer des fichiers KeePass2 !
				<p><a href="<?=base_url()?>register" class="btn btn-success btn-lg">S'inscrire !</a></p>
			</p>
			<div class="row">
				<div class="col-md-6">
					<h2>La sécurité avant tout</h2>
					<p>CatPass est totalement securisé: toutes vos données sont encryptées sur nos serveurs et nul ne peut accéder à vos données sans votre mot de passe principal.</p>
					<p><a class="btn btn-default" href="<?=base_url()?>secure" role="button">En savoir plus &raquo;</a></p>
				</div>
				<div class="col-md-6">
					<h2>Disponbile sur tous vos appareils</h2>
					<p>CatPass est conçu en prennant compte des navigateurs mobiles et dispose d'un affichage adapté à tout appareil grâce à son design responsive. Vous ne perdrez plus jamais vos mots de passe !</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<h2>Open-source</h2>
					<p>CatPass est disponible open-source. Ce qui veut dire que vous pouvez créer vous-même votre propre site CatPass, disposer des dernières mises à jour et être sûr que CatPass ne cherche pas à voler vos mots de passe.</p>
					<p><a class="btn btn-default" href="#" role="button">Voir les sources &raquo;</a></p>
				</div>
				<div class="col-md-6">
					<h2>Faire un don</h2>
					<p>CatPass est un gestionnaire de mots de passe gratuit et le restera toujours. Faites un don pour compenser toutes les bières bues pendant le développement du site !</p>
					<p><a class="btn btn-default" href="#" role="button">Faire un don &raquo;</a></p>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-12">
					<h2>Nouveautés</h2>
					<p><strong>Bientôt:</strong> Interface gestion de compte, déplacement entrées et groupes, captcha d'enregistrement, email de confirmation, page Github, page de dons.</p>
					<p><strong>09/07/2014</strong>: Ajout de l'import de fichier KeePass + page sécurité.</p>
					<p><strong>08/07/2014</strong>: Mise en ligne de CatPass.</p>
				</div>
			</div>
		</div>