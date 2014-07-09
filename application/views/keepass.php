<div class="starter-template">
	<h1>Importer un fichier KeePass</h1>
	<p class="lead">
		<div class="alert alert-danger alert-nohide" role="alert">
			<p style="text-align:center"><strong>Attention !</strong></p>
			<p>Pour importer un fichier KeePass dans CatPass, vous devez exporter votre base de donnée au format XML.</p>
			<p>Pour ce faire, vous devez ouvrir KeePass, aller dans <strong>File</strong>, puis <strong>Export</strong>, puis choisir <strong>KeePass XML (2.x)</strong>.
		</div>
	</p>
	<div class="row">
		<div class="col-md-6">
			<p>Tous les groupes contenus dans votre base de donnée KeePass seront créés dans CatPass avec un préfixe KP_</p>
		</div>
		<div class="col-md-6">
			<p>Envoyer ma base de donnée KeePass (XML)</p>
			<p style="text-align:center">
				<?php echo form_open_multipart('passwords/upload_keepass');?>
					<input style="margin-left:170px" type="file" name="userfile" size="2000" />
					<br />
					<input type="submit" class="btn btn-primary" value="Importer" />
				</form>
			</p>
		</div>
	</div>
</div>