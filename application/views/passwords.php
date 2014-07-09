<script>
	var BASE_URL = "<?=base_url()?>";
	var entries = <?=json_encode($entries)?>;
	var groups = <?=json_encode($groups)?>;
</script>
<div class="starter-template" style="text-align:center; margin-bottom:10px; margin-top:-20px">
	<?= isset($success) ? "<div class=\"row\"><div class=\"alert alert-success\"><span class=\"glyphicon glyphicon-ok\"></span> ".$success."</div></div>" : ""?>
	<?= isset($error) ? "<div class=\"row\"><div class=\"alert alert-danger\"><span class=\"glyphicon glyphicon-remove\"></span> ".$error."</div></div>" : ""?>
	<div class="row">
		<div class="col-md-2">
			<button type="button" class="btn btn-info" onclick="$('#modalNewGroup').modal('toggle')"><span class="glyphicon glyphicon-plus"></span> Ajouter un groupe</button>
		</div>
		<div class="col-md-2">
			<button type="button" class="btn btn-info disabled" onclick="editGroup()" id="btnEditGroup"><span class="glyphicon glyphicon-edit"></span> Modifier le groupe</button>
		</div>
		<div class="col-md-2">
			<button type="button" class="btn btn-info disabled" onclick="newEntry()" id="btnNewEntry"><span class="glyphicon glyphicon-pencil"></span> Ajouter une entrée</button>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="inputSearch" class="col-sm-2 control-label" style="padding-top:7px">Rechercher</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="inputSearch" placeholder="Rechercher">
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-2">
		<div class="list-group" id="groups">
		  <a href="#" onclick="displayGroup(0)" class="list-group-item active" id="group0">
			<span class="fa fa-list-alt"></span> Tous
		  </a>
		  <?php foreach($groups as $groupId => $group):?>
			<a href="#" onclick="displayGroup(<?=$groupId?>)" class="list-group-item" id="group<?=$groupId?>"><span class="<?=$group["icon"]?>"></span> <?=$group["name"]?></a>
		  <?php endforeach;?>
		</div>
	</div>
	<div class="col-md-10">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Titre</th>
					<th>Nom d'utilisateur</th>
					<th>Mot de passe</th>
					<th>URL</th>
					<th>Notes</th>
				</tr>
			</thead>
			<tbody id="tableData">
				<?php foreach($entries as $key => $entry): ?>
					<tr onclick="editEntry(<?=$key?>)" style="cursor:pointer">
						<td><span class="<?=$entry["icon"]?>"></span> <?=$entry["title"]?></td>
						<td><?=$entry["username"]?></td>
						<td><button type="button" class="btn btn-default btn-xs copy-button" data-clipboard-text="<?=$entry["password"]?>"><span class="fa fa-files-o"></span> Copier !</button></td>
						<td><a href="<?=$entry["url"]?>"><?=$entry["url"]?></a></td>
						<td><?=$entry["notes"]?></td>
					</tr>
				<?php endforeach;?>
			</tbody>
		</table>
	</div>
</div>
<!-- /.container -->
<div class="modal fade" id="modalNewEntry">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Ajouter une entrée</h4>
			</div>
			<form class="form-horizontal" role="form" action="<?=base_url()?>passwords/newEntry" method="post">
				<input type="hidden" id="newEntryGroupId" name="groupId" value="0">
				<div class="modal-body">
					<div class="form-group">
						<label for="inputTitleNew" class="col-sm-2 control-label">Titre</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="inputTitleNew" name="title" placeholder="Titre" tabindex="1" required>
						</div>
					</div>
					<div class="form-group">
						<label for="inputUsernameNew" class="col-sm-2 control-label">Nom d'utilsateur</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="inputUsernameNew" name="username" tabindex="2" placeholder="User name">
						</div>
					</div>
					<div class="form-group">
						<label for="inputPasswordNew" class="col-sm-2 col-xs-2 control-label">Mot de passe</label>
						<div class="col-sm-8" style="margin-right:-20px">
							<input type="password" class="form-control" id="inputPasswordNew" name="password" tabindex="3" placeholder="Password" required>
						</div>
						<div class="col-sm-1">
							<button class="btn btn-default btn-tooltip" id="btnGeneratePasswordNew" onclick="generatePassword('New')" type="button" data-toggle="tooltip" data-placement="top" title="Génerer"><span class="fa fa-key"></span> </button>
						</div>
						<div class="col-sm-1">
							<button class="btn btn-default btn-tooltip" id="btnViewPasswordNew" type="button" data-toggle="tooltip" data-placement="top" title="Voir le mot de passe"><span class="fa fa-eye"></span> </button>
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword2New" class="col-sm-2 control-label">Répéter</label>
						<div class="col-sm-10">
							<input type="password" class="form-control" id="inputPassword2New" name="password2" tabindex="4" placeholder="Repeat password" required>
						</div>
					</div>
					<div class="form-group">
						<label for="inputURLNew" class="col-sm-2 control-label">URL</label>
						<div class="col-sm-10">
							<input type="url" class="form-control" id="inputURLNew" name="url" tabindex="5" placeholder="URL">
						</div>
					</div>
					<div class="form-group">
						<label for="inputNotesNew" class="col-sm-2 control-label">Notes</label>
						<div class="col-sm-10">
							<textarea type="url" class="form-control" id="inputNotesNew" name="notes" tabindex="6" placeholder="Notes"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 col-xs-2 control-label">Icone</label>
						<div class="col-sm-1 col-xs-1">
							<label for="none" class="control-label">&nbsp;</label>
							<br/>
							<input id="none" type="radio" name="iconNew" value="0" checked>
						</div>
						<?php foreach($icons as $key => $value):?>
						<div class="col-sm-1 col-xs-1">
							<label for="<?=str_replace(" ", "", $value)?>" class="control-label"><span class="<?=$value?>"></span></label>
							<br/>
							<input id="<?=str_replace(" ", "", $value)?>" type="radio" name="iconNew" value="<?=$key?>">
						</div>
						<?php endforeach;?>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
					<input type="submit" class="btn btn-primary" value="Ajouter">
				</div>
			</form>
		</div>
	</div>
</div>


<div class="modal fade" id="modalEditEntry">
	<div class="modal-dialog">
		<div class="modal-content">
			<form class="form-horizontal" role="form" action="<?=base_url()?>passwords/editEntry" method="post">
				<div class="modal-header">
					<!--<form>
						<label for="moveEntry" class="col-sm-2 control-label">Déplacer vers</label>
						<select id="moveEntry" name="move" class="pull-right form-control">
							<option value="1">Windows</option>
							<option value="2">Jeux</option>
						</select>
					</form>-->
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title">Editer cette entrée</h4>
				</div>
				<div class="modal-body">
					<input id="inputEntryId" type="hidden" name="entryId" value="0">
					<div class="form-group">
						<label for="inputTitleEdit" class="col-sm-2 control-label">Titre</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="inputTitleEdit" name="title" placeholder="Titre">
						</div>
					</div>
					<div class="form-group">
						<label for="inputUsernameEdit" class="col-sm-2 control-label">Username</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="inputUsernameEdit" name="username" placeholder="User name">
						</div>
					</div>
					<div class="form-group">
						<label for="inputPasswordEdit" class="col-sm-2 control-label">Password</label>
						<div class="col-sm-8" style="margin-right:-20px">
							<input type="password" class="form-control" id="inputPasswordEdit" name="password" placeholder="Password">
						</div>
						<div class="col-sm-1">
							<button class="btn btn-default btn-tooltip" id="btnGeneratePasswordEdit" onclick="generatePassword('Edit')" type="button" data-toggle="tooltip" data-placement="top" title="Génerer"><span class="fa fa-key"></span> </button>
						</div>
						<div class="col-sm-1">
							<button class="btn btn-default" id="btnViewPasswordEdit" type="button"><span class="fa fa-eye"></span> </button>
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword2Edit" class="col-sm-2 control-label">Repeat</label>
						<div class="col-sm-10">
							<input type="password" class="form-control" id="inputPassword2Edit" name="password2" placeholder="Repeat password">
						</div>
					</div>
					<div class="form-group">
						<label for="inputURLEdit" class="col-sm-2 control-label">URL</label>
						<div class="col-sm-10">
							<input type="url" class="form-control" id="inputURLEdit" name="url" placeholder="URL"">
						</div>
					</div>
					<div class="form-group">
						<label for="inputNotesEdit" class="col-sm-2 control-label">Notes</label>
						<div class="col-sm-10">
							<textarea type="url" class="form-control" id="inputNotesEdit" name="notes" placeholder="Notes"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Icone</label>
						<div class="col-sm-1">
							<label for="editIconNone" class="control-label">&nbsp;</label>
							<br/>
							<input id="editIconNone" type="radio" name="iconEdit" value="0">
						</div>
						<?php foreach($icons as $key => $value):?>
						<div class="col-sm-1">
							<label for="edit<?=str_replace(" ", "", $value)?>" class="control-label"><span class="<?=$value?>"></span></label>
							<br/>
							<input id="edit<?=str_replace(" ", "", $value)?>" type="radio" name="iconEdit" value="<?=$key?>">
						</div>
						<?php endforeach;?>
					</div>
				</div>
				<div class="modal-footer">
					<a id="deleteEntry" class="btn btn-danger">Supprimer l'entrée</a>
					<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
					<input type="submit" class="btn btn-primary" value="Sauvegarder">
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="modalEditGroup">
	<div class="modal-dialog">
		<div class="modal-content">
			<form class="form-horizontal" role="form" action="<?=base_url()?>passwords/editGroup" method="post">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title">Editer ce groupe</h4>
				</div>
				<div class="modal-body">
					<input id="inputGroupId" type="hidden" name="groupId" value="0">
					<div class="form-group">
						<label for="inputNameEdit" class="col-sm-2 control-label">Nom</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="inputNameEdit" name="name" placeholder="Nom">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Icone</label>
						<div class="col-sm-1">
							<label for="editGroupIconNone" class="control-label">&nbsp;</label>
							<br/>
							<input id="editGroupIconNone" type="radio" name="iconEditGroup" value="0">
						</div>
						<?php foreach($icons as $key => $value):?>
						<div class="col-sm-1">
							<label for="editGroup<?=str_replace(" ", "", $value)?>" class="control-label"><span class="<?=$value?>"></span></label>
							<br/>
							<input id="editGroup<?=str_replace(" ", "", $value)?>" type="radio" name="iconEditGroup" value="<?=$key?>">
						</div>
						<?php endforeach;?>
					</div>
				</div>
				<div class="modal-footer">
					<a id="deleteGroup" class="btn btn-danger">Supprimer le groupe</a>
					<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
					<input type="submit" class="btn btn-primary" value="Sauvegarder">
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="modalNewGroup">
	<div class="modal-dialog">
		<div class="modal-content">
			<form class="form-horizontal" role="form" action="<?=base_url()?>passwords/newGroup" method="post">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title">Créer un groupe</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="inputNameNew" class="col-sm-2 control-label">Nom</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="inputNameNew" name="name" placeholder="Nom">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Icone</label>
						<div class="col-sm-1">
							<label for="newGroupIconNone" class="control-label">&nbsp;</label>
							<br/>
							<input id="newGroupIconNone" type="radio" name="iconGroup" value="0">
						</div>
						<?php foreach($icons as $key => $value):?>
						<div class="col-sm-1">
							<label for="editGroup<?=str_replace(" ", "", $value)?>" class="control-label"><span class="<?=$value?>"></span></label>
							<br/>
							<input id="editGroup<?=str_replace(" ", "", $value)?>" type="radio" name="iconGroup" value="<?=$key?>">
						</div>
						<?php endforeach;?>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
					<input type="submit" class="btn btn-primary" value="Créer">
				</div>
			</form>
		</div>
	</div>
</div>