
@if(session('status'))
	
	<div class="alert alert-info" role="alert">
		{{ session('status') }}
	</div>

@endif

@if(session('delete'))
	<div class="alert alert-dagger" role="alert">
		{{ session('delete') }}
	</div>
@endif
