@extends(config('laraticket.layout'))

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-6">
							<form class="form" method="POST">
								{{ csrf_field() }}
								<div class="table-responsive">
									<table class="table table-striped table-bordered">
										<thead>
											<th>Categories</th>

										</thead>
										<tbody>
											@forelse($categories as $category)
												<tr>
													<td>
														<input type="text" name="categories[]" class="form-control" value="{{ $category }}">
													</td>
												</tr>
											@empty
											@endforelse
											<tr>
												<td>
													<div class="">
														<input type="text" name="categories[]" class="form-control" placeholder="Add new category">	
													</div>
												</td>
											</tr>
										</tbody>
									</table>
									<button class="btn-primary btn btn-block">Update</button>
								</div>
							</form>		
						</div>
						<div class="col-6">
							<form method="POST">
								{{ csrf_field() }}
								<div class="table-responsive">
									<table class="table table-striped table-bordered">
										<thead>
											<th>Priorities</th>
										</thead>
										<tbody>
											@forelse($priorities as $priority)
												<tr>
													<td>
														<input type="text" name="priorities[]" class="form-control" value="{{ $priority }}">
													</td>
												</tr>
											@empty
											@endforelse
											<tr>
												<td>
													<div class="">
														<input type="text" name="priorities[]" class="form-control" placeholder="Add new priority">	
													</div>
													
												</td>
												
											</tr>
										</tbody>
									</table>
									<button class="btn-warning btn btn-block" type="submit">Update</button>
								</div>
							</form>	
						</div>
					</div>
					
				</div>
			</div>			
		</div>
	</div>
	</div>

@endsection