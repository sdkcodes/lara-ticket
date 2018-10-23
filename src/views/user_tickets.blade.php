@extends(config('laraticket.layout'))

@section('content')

<div class="container-fluid">
	<ul class="nav nav-tabs">
	  <li role="presentation" class="nav-item {{ is_null(Request::segment(2)) || Request::segment(2) == "open" ? 'active' : ''}}"><a href="{{ url('tickets/open') }}" class="nav-link">Open <span class="badge badge-secondary">{{ $open_count }}</span></a></li>
	  <li role="presentation" class="nav-item{{ Request::segment(2) == "closed" ? 'active' : ''}}"><a href="{{ url('tickets/closed') }}" class="nav-link">Closed <span class="badge badge-secondary">{{ $closed_count }}</span></a></li>
	  
	</ul>
	<section>
		<div class="card">
			<div class="card-header"><span class="h4">Tickets</span>
				<div class="float-right">
					<a href="{{ url('tickets/create') }}" class="btn btn-primary">Create new ticket</a>	
				</div>
				
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Subject</th>
								<th>Status</th>
								<th>Created</th>
								<th>Last updated</th>
								<th>Priority</th>
								<th>Owner</th>
								<th>Category</th>
							</tr>
						</thead>
						<tbody>
							@forelse($tickets as $ticket)
								<tr>
									<td><a href="{{ url('tickets/show/'.$ticket->slug) }}">{{ $ticket->title }}</a></td>
									<td>{{ $ticket->status }}</td>
									<td>{{ $ticket->created_at->diffForHumans() }}</td>
									<td>{{ $ticket->updated_at->diffForHumans() }}</td>
									<td>{{ $ticket->priority }}</td>
									<td>{{ $ticket->user_name }}</td>
									<td>{{ $ticket->category }}</td>
								</tr>
							@empty
							@endforelse
						</tbody>
					</table>
				</div>
				{{ $tickets->links() }}
			</div>
		</div>
	</section>
</div>
@endsection