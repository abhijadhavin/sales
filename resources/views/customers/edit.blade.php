
@extends('layouts.app')

@section('content')

	<!-- Bootstrap Boilerplate... -->
	<?php
		//print_r($customer); 
	?>
	<div class="container">
		<!-- Display Validation Errors -->
		@include('common.errors')

		<!-- New Task Form -->
		<form action="/lead/update_lead_data/{{$customer->id }}" method="POST" class="form-horizontal">
			{{ csrf_field() }}
			 
			<div class="panel panel-default">
				<div class="panel-heading">Edit Lead Details</div>
				<div class="panel-body">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">Today Date:</label>
						<div class="col-sm-10">							
							<div class="row">
								<div class="col-xs-3">
									<input type="date" name="op_date" class="form-control" id="tdate" placeholder="Today Date" required value="{{$customer->op_date }}">
								</div>
								<div class="col-xs-6"> &nbsp; </div>		
							</div>
						</div>
					</div>
					<?php /*
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">Executive Id:</label>
						<div class="col-sm-10">							
							<div class="row">
								<div class="col-xs-3">
									<input type="number" name="executive_id" class="form-control" id="executiveId" placeholder="Executive Id" required value="{{$customer->executive_id }}" >
								</div>
								<div class="col-xs-6"> &nbsp; </div>		
							</div>
						</div>
					</div>
					 */ ?>
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-2 control-label">Name:</label>
						<div class="col-sm-10">
							<div class="row">
							  <div class="col-xs-3">
								<input type="text" class="form-control" name="first_name" placeholder="First Name" required value="{{$customer->first_name }}" >
							  </div>
							  <div class="col-xs-3">
								<input type="text" class="form-control" name="middle_name" placeholder="Middle Name" value="{{ $customer->middle_name}}" >
							  </div>
							  <div class="col-xs-3">
								<input type="text" class="form-control" name="last_name" placeholder="Last Name" required value="{{ $customer->last_name}}">
							  </div>
							</div>
						</div>
					  </div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">Contact No:</label>
						<div class="col-sm-10">
							<div class="row">
								<div class="col-xs-3">
									<input type="text" class="form-control" name="contact" id="contact_no" placeholder="Contact No" required value="{{ $customer->contact }}">
								</div>
								<div class="col-xs-6"> &nbsp; </div>		
							</div>
						</div>
					</div>	
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">Email address:</label>
						<div class="col-sm-10">							
							<div class="row">
								<div class="col-xs-3">
									<input type="email" name="email" class="form-control" id="emailId" placeholder="Email address " required value="{{ $customer->email  }}" >
								</div>
								<div class="col-xs-6"> &nbsp; </div>		
							</div>
						</div>
					</div>			
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">Address:</label>
						<div class="col-sm-10">
							<div class="form-group row">
								<div class="col-xs-3">
									<input type="text" class="form-control" name="street_address1" placeholder="Street Address" required value="{{ $customer->street_address1 }}" >
								</div>
								<div class="col-xs-6"> &nbsp; </div>							 
							</div>							
							<div class="form-group row">
								<div class="col-xs-3">
									<input type="text" class="form-control" name="street_address2" placeholder="Street Address Line 2"  value="{{ $customer->street_address2  }}" >
								</div>
								<div class="col-xs-6"> &nbsp; </div>							 
							</div>
							<div class="form-group row">
								<div class="col-xs-4">
									<input type="text" class="form-control" name="suburb" placeholder="Suburb" required value="{{ $customer->suburb }}" >
								</div>
								<div class="col-xs-4">
									<input type="text" class="form-control" name="state" placeholder="State / Province" required value="{{ $customer->state }}" >
								</div>							  
							</div>							 
							<div class="form-group row">
								<div class="col-xs-3">
									<input type="text" class="form-control" name="postcode" placeholder="Postal / Zip Code" required value="{{ $customer->postcode }}" >									
								</div>
								<div class="col-xs-6"> &nbsp; </div>							 
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">Customer Type:</label>
						<div class="col-sm-10">
							<div class="form-group row">
								<div class="col-xs-3">
									<select name="customer_type" class="form-control">
										<option value=""> Select Type </option>
										<option value="Consumer" @if ( $customer->customer_type == "Consumer") {{ 'selected' }} @endif > Consumer</option>
										<option value="Business" @if ( $customer->customer_type == "Business") {{ 'selected' }} @endif > Business </option>
									</select>
								</div>
								<div class="col-xs-6"> &nbsp; </div>
							</div>	
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">Comments:</label>
						<div class="col-sm-10">							
							<div class="row">
								<div class="col-xs-4">
									<textarea rows="4" cols="50" class="form-control" name="comments" id="comments">{{ $customer->comments  }}</textarea>					 
								</div>
								<div class="col-xs-5"> &nbsp; </div>		
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">Form Submit As:</label>
						<div class="col-sm-10">
							<div class="form-group row">
								<div class="col-xs-3">
									<select name="form_type" id="formType" class="form-control">
										<option value="">   Type </option>
										<option value="lead" selected="selected" > Lead Form</option>
										<option value="sales"> Sales Form </option>
									</select>									
								</div>
								<div class="col-xs-6"> &nbsp; </div>
							</div>	
						</div>
					</div>
				</div>
			</div>

			<div class="panel panel-default" id="service-box" style="display:none">
				<div class="panel-heading">Service Details</div>
				<div class="panel-body" >
				 
					<div class="container">
						<div class="row">
							<div class="col-sm-9"> &nbsp;
							</div>	
							<div class="col-sm-2"> 
								<button type="button" class="btn btn-default" id="add_service">
									<i class="fa fa-plus"></i> Add Service
								</button>
							</div>	
						</div>
					</div>
					<br/>
					 
					<div class="well well-sm">
						<div class="container-fluid">							
							<div class="row" >
								<div class="panel panel-default">
									<div class="panel-heading">Selected Services</div>
									<div class="panel-body">									 
										<div class="table-responsive" id="table-container">
										<p>
											Please add the Service 
										</p>
										</div>
									</div>
								</div>										
							</div>
						</div>
					</div>
				</div>	
			</div>
			<!-- Task Name -->	 			 

			<!-- Add Task Button -->
			<div class="form-group">
				<div class="col-sm-offset-5 col-sm-4">
					<button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> SUBMIT</button>
					<button type="button" class="btn btn-warning" onclick="window.location='/'"><i class="fa fa-star"></i> CANCEL</button>
				</div>
			</div>
		</form>
	</div>

	<!-- TODO: Current Tasks -->
	 <div id="dialog" title="Add Service" style="display: none;">
	 	<div class="well well-sm">
	 	<form id="formService" class="form-horizontal">
	 		{{ csrf_field() }}			 
		   	<div class="container-fluid">							
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="inputCliNumber" class="col-sm-4 control-label">Cli Number: </label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="cli_number" id="inputCliNumber" placeholder="Cli Number" required value="{{ old('cli_number') }}" >
							</div>
						</div>
						<div class="form-group">
							<label for="intPlanName" class="col-sm-4 control-label">Plan Name: </label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="plan_name" id="intPlanName" placeholder="Plan Name" required value="{{ old('plan_name') }}" >									 
							</div>
						</div>
						<div class="form-group">
							<label for="inputPlanType" class="col-sm-4 control-label">Plan Type: </label>
							<div class="col-sm-8">
								<input type="text" class="form-control"  name="plan_type" id="inputPlanType" placeholder="Plan Type " required value="{{ old('plan_type') }}" >									 
							</div>
						</div>
						<div class="form-group">
							<label for="selContractStage" class="col-sm-4 control-label">Contract Stage: </label>
							<div class="col-sm-8">
								<select name="contract_stage" id="selContractStage" class="form-control">
									<option value=""> Select Contract Stage </option>
									<option value="Send" @if (old('contract_stage') == "Send") {{ 'selected' }} @endif > Send </option>
									<option value="Recived" @if (old('contract_stage') == "Recived") {{ 'selected' }} @endif > Recived </option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="selOrderStatus" class="col-sm-4 control-label">Order Status: </label>
							<div class="col-sm-8">
								<select name="order_status" id="selOrderStatus" class="form-control">
									<option value=""> Select Status </option>
									<option value="Pending" @if (old('order_status') == "Pending") {{ 'selected' }} @endif > Pending </option>
									<option value="Approved"> Approved </option>
									<option value="Cancelled"> Cancelled </option>
									<option value="Credit Declined"> Credit Declined </option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="inputddDetails" class="col-sm-4 control-label"> 
								Direct Debit Details: 
							</label>
							<div class="col-sm-8">
								<input type="text" class="form-control"  name="direct_debit_details" id="inputddDetails" placeholder="Direct Debit Details" required value="{{ old('direct_debit_details') }}" >									 
							</div>
						</div>									
					</div>	
					<div class="col-sm-6">										
						<div class="form-group">
							<label for="selProductType" class="col-sm-4 control-label">Product Type: </label>
							<div class="col-sm-8">
								<select name="product_type" id="selProductType" class="form-control">
									<option value=""> Select Product </option>
									<option value="Mobile"> Mobile </option>
									<option value="Mobile Broadband"> Mobile Broadband </option>
									<option value="NBN"> NBN </option>
									<option value="VOIP"> VOIP </option>
									<option value="Landline"> Landline </option>
									<option value="ADSL"> ADSL </option>
								</select>									 
							</div>
						</div>
						<div class="form-group">
							<label for="inputPlanValue" class="col-sm-4 control-label">Plan value:</label>
							<div class="col-sm-8">								
								<div class="input-group">
								  	<span class="input-group-addon" id="basic-addon1">$</span>
								  	<input type="text" class="form-control" name="plan_value" id="inputPlanValue" placeholder="Plan Value"  aria-describedby="basic-addon1" required value="{{ old('plan_value') }}" >	
								</div>									 
							</div>
						</div>
						<div class="form-group">
							<label for="inputHandsetType" class="col-sm-4 control-label">Handset Type </label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="handset_type" id="inputHandsetType" placeholder="Handset Type" required value="{{ old('handset_type') }}" >								 
							</div>
						</div>	
						<div class="form-group">
							<label for="inputHandsetType" class="col-sm-4 control-label">Handset value </label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="handset_value" id="inputHandsetValue" placeholder="Handset Type" required value="{{ old('handset_value') }}" >
							</div>
						</div>
						<div class="form-group">
							<label for="selIdStatus" class="col-sm-4 control-label">ID Status</label>
							<div class="col-sm-8">
								<select name="id_status" id="selIdStatus" class="form-control">
									<option value=""> Select Status</option>				
									<option value="Recived"> Recived </option>
									<option value="Pending"> Pending </option>
								</select>
							</div>
						</div>						
						<div class="form-group">
							<label for="inputOrderStatusDate" class="col-sm-4 control-label"> Order Status Date: </label>
							<div class="col-sm-8">
								<input type="date" class="form-control" name="order_status_date" id="inputOrderStatusDate" name="order_status_date" placeholder="Handset Type" required value="{{ old('order_status_date') }}" >								 
							</div>
						</div>		
					</div>	
				</div>
			</div>
		</form>	
		</div>			
	</div>
@endsection