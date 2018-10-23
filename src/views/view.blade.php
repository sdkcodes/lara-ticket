@extends(config('laraticket.layout'))

@section('content')

<div class="container-fluid">
	<section>
		<div class="card">
			<div class="card-header">
				{{-- <span class="h4">{{ $ticket->title }}</span> --}}
				<div class="text-right">
					<a href="{{ url('tickets/create') }}" class="btn btn-primary">Create new ticket</a>	
				</div>
				
			</div>
			<div class="card-body">
				<div class="h3">
					<i class="fa fa-sticky-note"></i> {{ $ticket->title }}
				</div>
				<br>
				<div class="row">
					<div class="col-sm-3">
						
						<strong>Ticket by: <span class="text-danger">{{ $ticket->user_name }}</span></strong>
						<br>
						<strong>Status: <span class="text-danger">{{ $ticket->status }}</span></strong>		
						<br>
						<strong>Category: <span class="text-danger">{{ $ticket->category }}</span></strong>
						<br>
						<strong>Priority: <span class="text-danger">{{ $ticket->priority }}</span></strong>
						<br>
						<strong>Opened: <span class="text-danger">{{ $ticket->created_at->diffForHumans() }}</span></strong>
					</div>
					<div class="col-sm-9">
						<div class="card">
							<div class="card-body">
								<p><strong>Description</strong></p>
								{!! $ticket->body !!}			
							</div>
						</div>
					</div>
				</div>
				
				<div style="margin-top: 15px; margin-bottom: 15px;">

					<p class="h4"><strong>Comments</strong></p>
					<div class="list-group">
						@forelse($ticket->comments as $comment)
							<li class="list-group-item">{{ $comment->body }}
								<span class="pull-right">{{ $comment->created_at->diffForHumans() }}</span>
								<br>
								<span class="pull-right">
									<span class="text-success">{{ $comment->user->name }}</span>
								</span>
							</li>
						@empty

						@endforelse	
					</div>
				</div>
				<div class="float-right">
					@if ($ticket->isOpen())
						<a class="btn btn-info" href="{{ url('tickets/'.$ticket->id.'/update?action=close') }}"><i class="fa fa-close"></i> Close</a>
						<button class="btn btn-primary" data-target="#reply-modal" data-toggle="modal">Reply</button>
					@elseif ($ticket->isClosed())
						<a class="btn btn-warning" href="{{ url('tickets/'.$ticket->id.'/update?action=open') }}"><i class="fa fa-open"></i> Reopen</a>
					@endif		
				</div>
			</div>
			<div class="card-footer">
				<form action="{{ url('tickets/'.$ticket->id) }}" method="POST">
					{{ method_field('DELETE')}}
					{{ csrf_field() }}
					<button class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
				</form>
			</div>
		</div>
	</section>
</div>
<div id="reply-modal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				Reply ticket
			</div>
			<div class="modal-body">
				<form method="POST" action="{{ url('tickets/comments/store/'.$ticket->id) }}">
					{{ csrf_field() }}
					<div class="form-group">
						<textarea class="form-control" name="content" placeholder="Enter your comment here"></textarea>
					</div>
					<div class="form-group">
						<button class="btn btn-warning">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection