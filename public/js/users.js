$(document).ready( function() {	
	$("#add_user").click(function(){
		create_user();
	});	 
});

function create_user() {
	if($("#dialogbox").length) { 
		var tag = $("#dialogbox");
	} else {	
		var tag = $("<div id=\"dialogbox\"></div>");
	}
	$(tag).attr("title", "Add User");
	$.ajax({
		type: "get",		 
		cache:false,
		url: "/users/create",
		success:function(result) {
			$("div").remove(".ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable");
			$(tag).dialog({
				autoOpen: false,
				resizable: false,
				height: "auto",
				width:"auto",
				modal: true,
				buttons: {
					Submit: function(){
						var formData = $("#formUser").serialize();	
						$.ajax({
							type:"POST",
							cache:false,
							data: formData,
							url: "/users/store",
							success: function(data) {								 
								if(data.success) {
									window.location = '/users';
								} else {
									var messageBlock = '<ul class="list-group">';
									$.each( data.response, function( key, value ) {									  	
									  	messageBlock += '<li class="list-group-item list-group-item-danger">'+value+'</li>';
									});			
									messageBlock += '</ul>';
									$("#errorMsg").html(messageBlock);
								}	
							}
						});
					},
					Cancel: function() {
						$(tag).dialog('destroy').remove();						
					}
				},
				close: function() {
					$("#name").removeClass( "ui-state-error" );					
				}
			});
			$(tag).dialog( "option", "width", 680 );
			$(tag).html(result).dialog().dialog('open');
		}
	});
}
 

function edit(editId) {
	if($("#dialogbox").length) { 
		var tag = $("#dialogboxedit");
	} else {	
		var tag = $("<div id=\"dialogboxedit\"></div>");
	}
	$(tag).attr("title", "Edit User");
	$.ajax({
		type: "get",		 
		cache:false,
		url: "/users/edit/"+editId,
		success:function(result) {
			$("div").remove(".ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable");
			$(tag).dialog({
				autoOpen: false,
				resizable: false,
				height: "auto",
				width:"auto",
				modal: true,
				buttons: {
					Submit: function(){
						var formData = $("#formUser").serialize();	
						$.ajax({
							type:"POST",
							cache:false,
							data: formData,
							url: "/users/update/"+editId,
							success: function(data) {								 
								if(data.success) {
									window.location = '/users';
								} else {
									var messageBlock = '<ul class="list-group">';
									$.each( data.response, function( key, value ) {									  	
									  	messageBlock += '<li class="list-group-item list-group-item-danger">'+value+'</li>';
									});			
									messageBlock += '</ul>';
									$("#errorMsg").html(messageBlock);
								}	
							}
						});
					},
					Cancel: function() {
						$(tag).dialog('destroy').remove();						
					}
				},
				close: function() {
					$("#name").removeClass( "ui-state-error" );					
				}
			});
			$(tag).dialog( "option", "width", 680 );
			$(tag).html(result).dialog().dialog('open');
		}
	});
}


function delete_user(key) {		 
	var message = 'Are you sure delete this record? ';
    $('<div></div>').appendTo('body')
    .html('<div><h6>'+message+'?</h6></div>')
    .dialog({
        modal: true, title: 'Delete message', zIndex: 10000, autoOpen: true,
        width: 'auto', resizable: false,
        buttons: {
            Yes: function () {               
                $("#delete-frm-"+key).submit();               
            },
            No: function () {                                                                                
                $(this).dialog("close");
            }
        },
        close: function (event, ui) {
            $(this).remove();
        }
    }); 
}


function center(editId) {
	if($("#dialogbox").length) { 
		var tag = $("#dialogcenter");
	} else {	
		var tag = $("<div id=\"dialogcenter\"></div>");
	}
	$(tag).attr("title", "Select User Center");
	$.ajax({
		type: "get",		 
		cache:false,
		url: "/users/center/"+editId,
		success:function(result) {
			$("div").remove(".ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable");
			$(tag).dialog({
				autoOpen: false,
				resizable: false,
				height: "auto",
				width:"auto",
				modal: true,
				buttons: {
					Submit: function(){
						var formData = $("#formCenter").serialize();	
						$.ajax({
							type:"POST",
							cache:false,
							data: formData,
							url: "/users/update_center/"+editId,
							success: function(data) {								 
								if(data.success) {
									window.location = '/users';
								} else {
									var messageBlock = '<ul class="list-group">';
									$.each( data.response, function( key, value ) {									  	
									  	messageBlock += '<li class="list-group-item list-group-item-danger">'+value+'</li>';
									});			
									messageBlock += '</ul>';
									$("#errorMsg").html(messageBlock);
								}	
							}
						});
					},
					Cancel: function() {
						$(tag).dialog('destroy').remove();						
					}
				},
				close: function() {
					$("#name").removeClass( "ui-state-error" );					
				}
			});
			$(tag).dialog( "option", "width", 680 );
			$(tag).html(result).dialog().dialog('open');
		}
	});
}