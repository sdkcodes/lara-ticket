@extends(config('laraticket.layout'))
@section('after_styles')
<!-- include summernote css/js -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.css" rel="stylesheet">
@endsection
@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-9 col-md-offset-2">
			@include('laraticket::errors.form_error')
			<form role="form" action="{{ url('tickets/store') }}" method="POST">
				{{ csrf_field() }}
				<div class="form-group">
					<div class="row">
						<div class="col-6">
							<label>Category</label>
							<select class="form-control" name="category">
								<option value="">Select a category</option>
								@forelse($categories as $category)
								<option>{{ $category }}</option>
								@empty
								@endforelse
							</select>
						</div>
						<div class="col-6">
							<label>Priority</label>
							<select class="form-control" name="priority">
								<option value="">Select priority</option>
								@forelse($priorities as $priority)
								<option>{{ $priority }}</option>
								@empty
								@endforelse
							</select>
						</div>	
					</div>
					
				</div>
				<div class="form-group">
					<label>Enter a subject for your ticket</label>
					<input type="text" name="title" class="form-control" max="255" value="{{ old('title') }}" placeholder="Subject of your ticket">
				</div>
				<div class="form-group">
					<label>Description</label>
					<textarea name="body" class="form-control" placeholder="Describe your complain in detail" id="editor"></textarea>
				</div>
				<div class="form-group">
					<button class="btn btn-success pull-right" type="submit">Sumbit Ticket</button>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection
@section('after_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.js"></script>
<script>
	$(document).ready(function(){
		$("#editor").summernote({
			placeholder: "Enter article content here",
			tabsize: 2,
			height:150
		});
	})
</script>
@endsection