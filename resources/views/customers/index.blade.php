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
						<div class="panel-heading">Customer List</div>
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
												<a class="btn btn-warning btn-xs" href="#" role="button"> 
													<i class="fa fa-edit"></i> Edit
												</a>
												<a class="btn btn-warning btn-xs" href="javascript:void(0)" onclick="delete_cust({{ $i }})" role="button">
													<i class="fa fa-remove"></i> Delete
												</a>
												<form id="delete-frm-{{ $i }}" action="{{action('CustomersController@destroy', $customer->id)}}" method="post">
								                    {{csrf_field()}}								                    
								                </form>
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