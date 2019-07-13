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
						<label for="inputRole" class="col-sm-4 control-label"> Select Center: </label>
						<div class="col-sm-8">
							<select class="custom-select form-control" required name="role" id="role">
								<option value=""> Select Center </option>
								@if ($centers)
									@foreach($centers as $center)										 
										<option value="{{ $center->id }}">{{ $center->name }}</option>
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
