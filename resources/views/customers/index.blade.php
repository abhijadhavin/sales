@extends('layouts.app')

@section('content')

	<!-- Bootstrap Boilerplate... -->
  
	<div class="panel-body">

	<!-- New Task Form -->
	<div class="container">
		<!-- Display Validation Errors -->
		@include('common.errors')

		<div class="jumbotron">
			<div class="container-fluid">			 
				<div class="row">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="container">
								<form class="form-inline" method="post" action="/download" >
									{{ csrf_field() }}
									<div class="form-group">
										<label for="email">From Date:</label>
										<input type="date" class="form-control" name="formDate" id="formDate" style="line-height: 15px;" >&nbsp;&nbsp;
									</div>
									<div class="form-group">
										<label for="pwd">To Date:</label>
										<input type="date" class="form-control" name="toDate" id="toDate" style="line-height: 15px;" >&nbsp;&nbsp;
									</div>
									<div class="checkbox">
									    <label><input type="checkbox" name="records" /> All Records &nbsp;&nbsp;</label>
									</div>							 
									<button type="submit" class="btn btn-primary"><i class="fa fa-download"></i> Export Sale Data</button>
								</form> 
							</div>
						</div>
					</div>	
				</div> 	 
				<div class="row"> 
					<div class="panel panel-default">
						<div class="panel-heading">Sales Customer List</div>
							<div class="panel-body">									 
								<div class="table-responsive">
								<table class="table table-striped">
									<thead>
										<tr>
											<th>#</th>
											<th>Name </th>
											<th>Contact No</th>
											<th>Customer Type</th>
											<th>Date</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($customers as $customer)
										<tr>
											<td>{{ ++$i }}</td>
											<td>{!! $customer->first_name.' '.$customer->last_name !!}</td>
											<td>{!! $customer->contact !!}</td>
											<td>{!! $customer->customer_type !!}</td>
											<td>{!! $customer->op_date !!}</td>
											<td> &nbsp 
												<a class="btn btn-warning btn-xs" href="{{ URL::to('sale/edit/' . $customer->id) }}" role="button"> 
													<i class="fa fa-edit"></i> Edit
												</a>
												<?php 
												/*
												<a class="btn btn-warning btn-xs" href="javascript:void(0)" onclick="delete_cust({{ $i }})" role="button">
													<i class="fa fa-remove"></i> Delete
												</a>												
												<form id="delete-frm-{{ $i }}" action="{{action('CustomersController@destroy', $customer->id)}}" method="post">
													{{csrf_field()}}								                    
												</form>
												*/
												?>
											</td>
										</tr>
										@endforeach		                          
									</tbody>
									<tfoot>
										<tr>
											<td colspan="6">
												{!! $customers->links('pagination') !!}	
											</td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
@endsection