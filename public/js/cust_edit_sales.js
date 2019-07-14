$(document).ready( function() {	
	$("#add_service").click(function(){
		$("#dialog").dialog({
			width: 970,
			modal: true,
			open: function () {
				var closeBtn = $('.ui-dialog-titlebar-close');
				closeBtn.append('<span class="ui-button-icon-primary ui-icon ui-icon-closethick"></span>');
				$("#formService").get(0).reset();
			},
			close: function () {
				var closeBtn = $('.ui-dialog-titlebar-close');
				closeBtn.html('');
			},
			buttons: {
				"Submit": function () {					
					var formData = $("#formService").serialize();					 
					$.ajax({
						type: "POST",
						url: "/services",
						data: formData, // serializes the form's elements.
						success: function(data) {
						   //console.log(data.success); // show response from the php script.
						   if(data.success) {
								var $table = $('<table class="table table-striped" />');
								var data = data.response;
								$table.append( '<thead><tr><th>Cli Number</th><th>Plan Name</th><th>Plan Price</th><th>Plan Type</th><th>Product Type</th><th>Action</th></tr></thead>' );
								$table.append( '<tbody>' );
								$.each( data, function( key, row) {							  		
									var hidden = row.cli_number+' <input type="hidden" name="services[]" value="'+key+'" />';
									var deleteRow = '<a class="btn btn-warning btn-xs" href="javascript:void(0)" onclick="delete_service('+ key+')" role="button"><i class="fa fa-remove"></i> Delete </a>';
									$table.append( '<tr><td>'+ hidden+' </td><td>'+ row.plan_name + '</td><td>'+ row.plan_price + '</td><td>'+ row.plan_type + '</td><td>'+ row.product_type + '</td><td> '+deleteRow+' </td></tr>' );
								});							
								$table.append( '</tbody>' );	 
								$('#table-container').html($table);
							}
						   $("#dialog").dialog("close");
					   }
					});
				},
				"Cancel": function () {
					$(this).dialog("close");
				}
			}
		});
		$("#dialog").dialog("open");
	});


	$('#formType').on('change', function() {
		var selected = $(this).find(":selected").val();
		if(selected === 'lead') {
			$("#service-box").hide('slow');
		} else {
			$("#service-box").show('slow');
		}	    
	}); 

	load_service();
});


function load_service() {
	var editId = $("#editCustId").val();
	if(typeof editId  !== 'undefined' && editId > 0) {
		var formData = $("#formService").serialize();	
		$.ajax({
			type: "POST",
			url: "/sale/load_services/"+editId,	
			data: formData,	
			success: function(data) {			   
			   if(data.success) {
					var $table = $('<table class="table table-striped" />');
					var data = data.response;
					$table.append( '<thead><tr><th>Cli Number</th><th>Plan Name</th><th>Plan Price</th><th>Plan Type</th><th>Product Type</th><th>Action</th></tr></thead>' );
					$table.append( '<tbody>' );
					$.each( data, function( key, row) {							  		
						var hidden = row.cli_number+' <input type="hidden" name="services[]" value="'+key+'" />';
						var deleteRow = '<a class="btn btn-warning btn-xs" href="javascript:void(0)" onclick="delete_service('+ key+')" role="button"><i class="fa fa-remove"></i> Delete </a>';
						$table.append( '<tr><td>'+ hidden+' </td><td>'+ row.plan_name + '</td><td>'+ row.plan_price + '</td><td>'+ row.plan_type + '</td><td>'+ row.product_type + '</td><td> '+deleteRow+' </td></tr>' );
					});							
					$table.append( '</tbody>' );	 
					$('#table-container').html($table);
				}			   
			}
		}); 
	}
}


function delete_service(key) {
	var message = 'Are you sure delete this record? ';
	$('<div></div>').appendTo('body')
	.html('<div><h6>'+message+'?</h6></div>')
	.dialog({
		modal: true, 
		title: 'Delete message', 
		zIndex: 10000, 
		autoOpen: true,
		width: 400, 
		resizable: false,
		buttons: {
			Yes: function () {
				confim_delete_service(key);  
				$(this).dialog("close");            
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



function confim_delete_service(key) {
	$.ajax({
		type: "GET",
		url: "/services/destroy/"+key,		
		success: function(data) {
			if(data.success) {
				var $table = $('<table class="table table-striped" />');
				var data = data.response;
				$table.append( '<thead><tr><th>Cli Number</th><th>Plan Name</th><th>Plan Price</th><th>Plan Type</th><th>Product Type</th><th>Action</th></tr></thead>' );
				$table.append( '<tbody>' );
				$.each( data, function( key, row) {							  		
					var hidden = row.cli_number+' <input type="hidden" name="services[]" value="'+key+'" />';
					var deleteRow = '<a class="btn btn-warning btn-xs" href="javascript:void(0)" onclick="delete_service('+ key+')" role="button"><i class="fa fa-remove"></i> Delete </a>';
					$table.append( '<tr><td>'+ hidden+' </td><td>'+ row.plan_name + '</td><td>'+ row.plan_price + '</td><td>'+ row.plan_type + '</td><td>'+ row.product_type + '</td><td> '+deleteRow+' </td></tr>' );
				});							
				$table.append( '</tbody>' );	 
				$('#table-container').html($table);
			}
		}
	});	    	
}