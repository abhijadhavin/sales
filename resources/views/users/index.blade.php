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
						<div class="panel-heading">
							<div class="btn-group pull-right">
						        <a href="javascript:void(0)" id="add_user" class="btn btn-warning btn-sm"> <i class="fa fa-file"></i> Add User</a>
						        
						    </div>
						    <h4>Manage Users</h4>
						</div>
							<div class="panel-body">									 
								<div class="table-responsive">
								<table class="table table-striped">
									<thead>
										<tr>
											<th>#</th>											
											<th>User Name</th>
											<th>Email Id</th>
											<th>Create Date</th>											
											<th  width="20%">Action</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($users as $user)
										<tr>
											<td>{{ ++$i }}</td>											
											<td>{!! $user->name !!}</td>
											<td>{!! $user->email !!}</td>
											<td>{!! $user->created_at !!}</td>
											<td> 
												<a class="btn btn-warning btn-xs" href="javascript:void(0)" onclick="javascript:edit('{{$user->id}}')" role="button"> 
													<i class="fa fa-edit"></i> Edit
												</a>												 											 
												<a class="btn btn-warning btn-xs" href="javascript:void(0)" onclick="delete_user({{ $i }})" role="button">
													<i class="fa fa-remove"></i> Delete
												</a>
												<a class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="javascript:center('{{$user->id}}')" role="button" placeholder="Add/Edit Center" > 
													<i class="fa fa-edit"></i> Center
												</a>	
												<form id="delete-frm-{{ $i }}" action="{{action('UsersController@destroy', $user->id)}}" method="post">
													{{csrf_field()}}                
												</form> 												
											</td>
										</tr>
										@endforeach		                          
									</tbody>
									<tfoot>
										<tr>
											<td colspan="6">
												{!! $users->links('pagination') !!}	
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