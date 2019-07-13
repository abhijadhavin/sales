<div class="well well-sm">
	<form id="formUser" class="form-horizontal">
		<div class="container-fluid">
			<div class="row"><div class="col-lg-10 offset-lg-1" id="errorMsg"></div></div>
		</div>			
		{{ csrf_field() }}			 
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<div class="form-group">
						<label for="inputUsername" class="col-sm-4 control-label"> User Name: </label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="name" id="idname" placeholder="User Name" value="{{$user->name}}" required  >
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail" class="col-sm-4 control-label"> Email: </label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="email" id="email" value="{{$user->email}}"  placeholder="Email" required>								 
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword" class="col-sm-4 control-label"> Password: </label>
						<div class="col-sm-8">
							<input type="Password" class="form-control" name="password" id="password" placeholder="Password"  >								 
						</div>
					</div>
					<div class="form-group">
						<label for="inputConfirmPassword" class="col-sm-4 control-label"> Confirm Password: </label>
						<div class="col-sm-8">
							<input type="Password" class="form-control" name="password_confirmation" id="confimpassword" placeholder="confimpassword" >	
						</div>
					</div>
					<div class="form-group">
						<label for="inputRole" class="col-sm-4 control-label"> Role: </label>
						<div class="col-sm-8">
							<select class="custom-select form-control" required name="role" id="role">
								<option value=""> Select Role </option>
								@if ($roles)
									@foreach($roles as $role)
										@if ($currentRole)
                                            <option value="{{ $role->id }}" {{ $currentRole->role_id == $role->id ? 'selected="selected"' : '' }}>{{ $role->name }}</option>
                                        @else
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endif										
									@endforeach
								@endif
							</select>    						 
						</div>
					</div>
				</div>
			</div>		
		</div>
	</form>
</div>	   		
