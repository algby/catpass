<div class="starter-template">
	<div class="row">
		<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
			<form role="form" method="post" action="<?=base_url()?>login/register">
				<h2>Enregistrez-vous <small>C'est gratuit et ça le sera toujours.</small></h2>
				<hr class="colorgraph">			
				<?= isset($success) ? "<div class=\"row\"><div class=\"alert alert-success\"><span class=\"glyphicon glyphicon-ok\"></span> ".$success."</div></div>" : ""?>
				<?= isset($error) ? "<div class=\"row\"><div class=\"alert alert-danger\"><span class=\"glyphicon glyphicon-remove\"></span> ".$error."</div></div>" : ""?>
				<div class="form-group">
					<input type="email" name="email" id="email" class="form-control input-lg" placeholder="Adresse Email" tabindex="4">
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-6 col-md-6">
						<div class="form-group">
							<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Mot de passe" tabindex="5">
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6">
						<div class="form-group">
							<input type="password" name="password2" id="password_confirmation" class="form-control input-lg" placeholder="Confirmer" tabindex="6">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4 col-sm-3 col-md-3">
						<span class="button-checkbox">
							<button type="button" class="btn" data-color="info" tabindex="7">J'accepte</button>
							<input type="checkbox" name="t_and_c" id="t_and_c" class="hidden" value="1">
						</span>
					</div>
					<div class="col-xs-8 col-sm-9 col-md-9">
						En cliquant sur <strong class="label label-primary">S'inscrire</strong>, vous acceptez les <a href="#" data-toggle="modal" data-target="#t_and_c_m">Termes et Conditions</a> établis par ce site, incluant l'usage des Cookies.
					</div>
				</div>			
				<hr class="colorgraph">
				<div class="row">
					<div class="col-xs-12 col-md-12"><input type="submit" value="S'inscrire" class="btn btn-primary btn-block btn-lg" tabindex="7"></div>
				</div>
			</form>
		</div>
	</div>
	<!-- Modal -->
	<div class="modal fade" id="t_and_c_m" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="myModalLabel">Termes & Conditions</h4>
				</div>
				<div class="modal-body">
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal">J'accepte</button>
				</div>
			</div>
		</div>
	</div>
</div>