$(document).ready( function() {	
	$("#add_service").click(function(){
		service_from_reset();
		$("#oldId").val('-1');  
		$("#dialog").dialog({
			width: 970,
			modal: true,
			title: "Add Services",
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
									var editRow = '<a class="btn btn-warning btn-xs" href="javascript:void(0)" onclick="edit_service('+ key+')" role="button"><i class="fa fa-edit"></i> Edit </a>';
									var deleteRow = '<a class="btn btn-warning btn-xs" href="javascript:void(0)" onclick="delete_service('+ key+')" role="button"><i class="fa fa-remove"></i> Delete </a>';
									$table.append( '<tr><td>'+ hidden+' </td><td>'+ row.plan_name + '</td><td>'+ row.plan_price + '</td><td>'+ row.plan_type + '</td><td>'+ row.product_type + '</td><td> '+editRow+'&nbsp;&nbsp;'+deleteRow+' </td></tr>' );
								});                         
								$table.append( '</tbody>' );     
								$('#table-container').html($table);
							}
							$("#dialog").dialog("close");
						},
						error: function(jqXhr, json, errorThrown){// this are default for ajax errors 
							var errors = jqXhr.responseJSON;
							var errorsHtml = '';
							$.each(errors['errors'], function (index, value) {
								errorsHtml += '<ul class="list-group"><li class="list-group-item alert alert-danger">' + value + '</li></ul>';
							});
							//I use SweetAlert2 for this
							if(errorsHtml !== '') {
								$("#dialogError").html(errorsHtml);
							} else{
								alert(errorThrown);
							}
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
});



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

function edit_service(key){ 
	$.ajax({
		type: "GET",
		url: "/services/edit/"+key,     
		success: function(data) {          
		   if(data.success) {
				//service_from_reset()
				edit(key);
				var data = data.response;   
				$.each( data, function( field, val) {
					//console.log(field + " ==> "+ val);
					if(field == 'cli_number') {                     
						$("#inputCliNumber").val(val);
					} else if(field == 'product_type') {                        
						$("#selProductType").val(val);
					} else if(field == 'plan_name') {
						$("#intPlanName").val(val);
					} else if(field == 'plan_price') {
						$("#inputPlanValue").val(val);
					} else if(field == 'plan_type') {
						$("#inputPlanType").val(val);
					} else if(field == 'handset_type') {
						$("#inputHandsetType").val(val);
					} else if(field == 'handset_value') {
						$("#inputHandsetValue").val(val);
					} else if(field == 'contract_stage') {
						$("#selContractStage").val(val);
					} else if(field == 'id_status') {
						$("#selIdStatus").val(val);
					} else if(field == 'direct_debit_details') {
						$("#inputddDetails").val(val);
					} else if(field == 'order_status') {
						$("#selOrderStatus").val(val);
					} else if(field == 'order_status_date') {
						$("#inputOrderStatusDate").val(val);
					} else {
						console.log(field + " ==> "+ val);
					}
				});
				 
			} else {
				alert(data.response);
			}
		}
	}); 
}

function service_from_reset() {
	$("#inputCliNumber").val('');
	$("#intPlanName").val('');
	$("#inputPlanType").val('');
	$("#selContractStages").val('');
	$("#selOrderStatus").val('');
	$("#inputddDetails").val('');
	$("#selProductType").val('');
	$("#inputPlanValue").val('');
	$("#inputHandsetType").val('');
	$("#inputHandsetValue").val('');
	$("#selIdStatus").val('');
	$("#inputOrderStatusDate").val('');
	$("#dialogError").html('');
}

function edit(key){ 
	$("#dialogError").html('');
	$("#oldId").val(key);   
	$("#dialog").dialog({
			width: 970,
			modal: true,
			title: "Edit Services",
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
									var editRow = '<a class="btn btn-warning btn-xs" href="javascript:void(0)" onclick="edit_service('+ key+')" role="button"><i class="fa fa-edit"></i> Edit </a>';
									var deleteRow = '<a class="btn btn-warning btn-xs" href="javascript:void(0)" onclick="delete_service('+ key+')" role="button"><i class="fa fa-remove"></i> Delete </a>';
									$table.append( '<tr><td>'+ hidden+' </td><td>'+ row.plan_name + '</td><td>'+ row.plan_price + '</td><td>'+ row.plan_type + '</td><td>'+ row.product_type + '</td><td> '+editRow+'&nbsp;&nbsp;'+deleteRow+' </td></tr>' );
								});                         
								$table.append( '</tbody>' );     
								$('#table-container').html($table);
							}
						   	$("#dialog").dialog("close");
						},
						 error: function(jqXhr, json, errorThrown){// this are default for ajax errors 
							var errors = jqXhr.responseJSON;
							var errorsHtml = '';
							$.each(errors['errors'], function (index, value) {
								errorsHtml += '<ul class="list-group"><li class="list-group-item alert alert-danger">' + value + '</li></ul>';
							});
							//I use SweetAlert2 for this
							if(errorsHtml !== '') {
								$("#dialogError").html(errorsHtml);
							} else{
								alert(errorThrown);
							}
						}
					});
				},
				"Cancel": function () {
					$(this).dialog("close");
				}
			}
		});
		$("#dialog").dialog("open");
}
