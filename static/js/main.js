$(function () {
	// fade alerts
	$(".alert").each(function() {
		if(!$(this).hasClass("alert-nohide")){
			$(this).fadeTo(2000, 500).slideUp(500, function(){
				$(this).alert('close');
			});
		}
	});

	// init zeroclipboard
	initZeroClipboard();
	
	// tooltips
	$(".btn-tooltip").tooltip();
	
	// password show
	$("#btnViewPasswordEdit").mousedown(function() {
		$("#inputPasswordEdit").attr("type", "text");
	});
	$("#btnViewPasswordEdit").mouseup(function() {
		$("#inputPasswordEdit").attr("type", "password");
	});
	$("#btnViewPasswordNew").mousedown(function() {
		$("#inputPasswordNew").attr("type", "text");
	});
	$("#btnViewPasswordNew").mouseup(function() {
		$("#inputPasswordNew").attr("type", "password");
	});
	
	// sexy checkboxes
	$('.button-checkbox').each(function () {
		// Settings
		var $widget = $(this),
		$button = $widget.find('button'),
		$checkbox = $widget.find('input:checkbox'),
		color = $button.data('color'),
		settings = {
			on: {
				icon: 'glyphicon glyphicon-check'
			},
			off: {
				icon: 'glyphicon glyphicon-unchecked'
			}
		};
		// Event Handlers
		$button.on('click', function () {
			$checkbox.prop('checked', !$checkbox.is(':checked'));
			$checkbox.triggerHandler('change');
			updateDisplay();
		});
		$checkbox.on('change', function () {
			updateDisplay();
		});

		// Actions
		function updateDisplay() {
			var isChecked = $checkbox.is(':checked');
			// Set the button's state
			$button.data('state', (isChecked) ? "on" : "off");
			// Set the button's icon
			$button.find('.state-icon')
				.removeClass()
				.addClass('state-icon ' + settings[$button.data('state')].icon);
			// Update the button's color
			if (isChecked) {
				$button
					.removeClass('btn-default')
					.addClass('btn-' + color + ' active');
			}
			else {
				$button
					.removeClass('btn-' + color + ' active')
					.addClass('btn-default');
			}
		}
		// Initialization
		function init() {
			updateDisplay();
			// Inject the icon if applicable
			if ($button.find('.state-icon').length == 0) {
				$button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i> ');
			}
		}
		init();
	});
	
	// display group count
	$("#groups").find("a").each(function(){
		var groupId = $(this).attr("id").substring(5, $(this).attr("id").length);
		var count = 0;
		for(var k in entries)
		{
			if(entries[k]["groupId"] == groupId || groupId == 0)
				count++;
		}
		$(this).append("<span class='badge'>"+count+"</span>");
	});
	
	// display last tab
	if($.cookie('tab'))
		displayGroup($.cookie('tab'));
	
	// search
	$("#inputSearch").keyup(function(){
		var search = $("#inputSearch").val().toLowerCase();
		if(search.length == 0)
		{
			$("#groups").find("a").each(function(){ $(this).removeClass("active");});
			$("#group0").addClass("active");
			$("#tableData").html("");
			for(var k in entries)
			{
				addEntryToTable(k);
			}
		}
		else
		{
			$("#groups").find("a").each(function(){ $(this).removeClass("active");});
			$("#tableData").html("");
			for(var k in entries)
			{
				if(entries[k]["title"].toLowerCase().indexOf(search) != -1 ||
				   entries[k]["username"].toLowerCase().indexOf(search) != -1 ||
				   entries[k]["url"].toLowerCase().indexOf(search) != -1 ||
				   entries[k]["notes"].toLowerCase().indexOf(search) != -1)
					addEntryToTable(k);
			}
		}
		initZeroClipboard();
	});
});
function displayGroup(groupId)
{
	$("#groups").find("a").each(function(){ $(this).removeClass("active");});
	$("#group"+groupId).addClass("active");
	$("#tableData").html("");
	if(groupId == 0)
	{
		$("#btnEditGroup").addClass("disabled");
		$("#btnNewEntry").addClass("disabled");
	}
	else
	{
		$("#btnEditGroup").removeClass("disabled");
		$("#btnNewEntry").removeClass("disabled");
	}
	for(var k in entries)
	{
		if(entries[k]["groupId"] == groupId || groupId == 0)
		{	
			$("#tableData").append("<tr onclick='editEntry("+k+")' style='cursor:pointer'>"+
							"<td><span class='"+entries[k]["icon"]+"'></span> "+entries[k]["title"]+"</td>"+
							"<td>"+entries[k]["username"]+"</td>"+
							"<td><button type='button' class='btn btn-default btn-xs copy-button' data-clipboard-text='"+entries[k]["password"]+"'><span class='fa fa-files-o'></span> Copier !</button></td>"+
							"<td><a href='"+entries[k]["url"]+"'>"+entries[k]["url"]+"</a></td>"+
							"<td>"+entries[k]["notes"]+"</td>"+
						"</tr>");
		}
	}
	initZeroClipboard();
	$.cookie('tab', groupId);
}
function newEntry()
{
	var group = $($("#groups").find($(".active"))).first();
	var groupId = group.attr("id").substring(5, group.attr("id").length);
	$("#newEntryGroupId").val(groupId);
	$('#modalNewEntry').modal('toggle');
}
function editEntry(entryId)
{
	$("#inputEntryId").val(entryId);
	$("#inputTitleEdit").val(entries[entryId]["title"]);
	$("#inputUsernameEdit").val(entries[entryId]["username"]);
	$("#inputPasswordEdit").val(entries[entryId]["password"]);
	$("#inputPassword2Edit").val(entries[entryId]["password"]);
	$("#inputURLEdit").val(entries[entryId]["url"]);
	$("#inputNotesEdit").val(entries[entryId]["notes"]);
	$("#deleteEntry").attr("onclick", "warningDeleteEntry("+entryId+")");
	if(entries[entryId]["iconId"] == 0) {
		$("#editIconNone").attr("checked", "true");
	}
	else {
		$("#edit"+entries[entryId]["icon"].replace(" ", "")).attr("checked", "true");
	}	
	$("#modalEditEntry").modal("toggle");
}

function editGroup()
{
	var group = $($("#groups").find($(".active"))).first();
	var groupId = group.attr("id").substring(5, group.attr("id").length);
	$("#inputGroupId").val(groupId);
	$("#inputNameEdit").val(groups[groupId]["name"]);
	$("#deleteGroup").attr("onclick", "warningDeleteGroup("+groupId+")");
	if(groups[groupId]["iconId"] == 0) {
		$("#editGroupIconNone").attr("checked", "true");
	}
	else {
		$("#editGroup"+groups[groupId]["icon"].replace(" ", "")).attr("checked", "true");
	}	
	$("#modalEditGroup").modal("toggle");
}
function generatePassword(elem)
{
	$password = $("#inputPassword"+elem);
	$password2 = $("#inputPassword2"+elem);
	var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz&#{([_@)}]=+!*$";
	var string_length = 10;
	var randomstring = '';
	for (var i=0; i<string_length; i++) {
	var rnum = Math.floor(Math.random() * chars.length);
		randomstring += chars.substring(rnum,rnum+1);
	}
	$password.val(randomstring);
	$password2.val(randomstring);
}
function warningDeleteEntry(entryId)
{
	if(confirm("Êtes-vous sûr de vouloir supprimer cette entrée ?"))
		window.location = BASE_URL+"passwords/deleteEntry/"+entryId;
}
function warningDeleteGroup(groupId)
{
	if(confirm("Êtes-vous sûr de vouloir supprimer ce groupe ?\n!! ATTENTION CETTE ACTION SUPPRIMERA TOUTES LES ENTREES DE CE GROUPE !!"))
		window.location = BASE_URL+"passwords/deleteGroup/"+groupId;

}
// helper function
function addEntryToTable(id)
{
	$("#tableData").append("<tr onclick='displayEntry("+id+")' style='cursor:pointer'>"+
		"<td><span class='"+entries[id]["icon"]+"'></span> "+entries[id]["title"]+"</td>"+
		"<td>"+entries[id]["username"]+"</td>"+
		"<td><button type='button' class='btn btn-default btn-xs copy-button' data-clipboard-text='"+entries[id]["password"]+"'><span class='fa fa-files-o'></span> Copier !</button></td>"+
		"<td><a href='"+entries[id]["url"]+"'>"+entries[id]["url"]+"</a></td>"+
		"<td>"+entries[id]["notes"]+"</td>"+
		"</tr>");
}
function initZeroClipboard()
{
	$(".copy-button").on("click", function(event){event.stopPropagation();});
	ZeroClipboard.config( { swfPath: "//cdnjs.cloudflare.com/ajax/libs/zeroclipboard/2.1.5/ZeroClipboard.swf" } );
	var client = new ZeroClipboard($(".copy-button"));
	client.on( "ready", function( readyEvent ) {
		client.on( "aftercopy", function( event ) {
			$btn = $(event.target);
			$btn.removeClass("btn-default").addClass("btn-success").html("<span class='fa fa-check-circle'></span> Copié !");
			$btn.fadeTo(2000, 500, function(){
				$btn.fadeTo(200, 0, function(){
					$btn.fadeTo(200, 1);
					$btn.removeClass("btn-success").addClass("btn-default").html("<span class='fa fa-files-o'></span> Copier !");
				});
			});
		});
	});
}