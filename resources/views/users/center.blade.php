<div class="well well-sm">
	<form id="formCenter" class="form-horizontal">
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
							<select class="custom-select form-control" multiple required name="center[]" id="center">
								@if ($centers)
									@foreach($centers as $center)
										@if (in_array($center->id, $currentCenters))
                                            <option value="{{ $center->id }}" selected="selected" >{{ $center->name }}</option>
                                        @else
                                            <option value="{{ $center->id }}">{{ $center->name }}</option>
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
