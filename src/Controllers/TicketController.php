<?php

namespace Sdkcodes\LaraTicket\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Sdkcodes\LaraTicket\Models\Ticket;
use Illuminate\Support\Facades\Notification;
use Sdkcodes\LaraTicket\Models\TicketOption;
use Sdkcodes\LaraTicket\Models\TicketComment;
use Sdkcodes\LaraTicket\Events\TicketSubmitted;
use Sdkcodes\LaraTicket\Events\TicketClosed;
use Sdkcodes\LaraTicket\Events\TicketDeleted;
use Sdkcodes\LaraTicket\Events\TicketReplied;
use Sdkcodes\LaraTicket\Notifications\TicketNotification;

class TicketController extends Controller
{
    protected $perPage = "";

    public function __construct(){
        $this->perPage = config('laraticket.per_page');
    }

    public function index($status="open"){
		
    	if (!auth()->user()->isTicketAdmin()){
    		$tickets = auth()->user()->tickets()->where('status', $status)->paginate($this->perPage);
    		$data['title'] = $data['breadcrumb'] = "Tickets";
    		$data['tickets'] = $tickets;
    		$data['open_count'] = auth()->user()->countTickets("open");
    		$data['closed_count'] = auth()->user()->countTickets("closed");
    		return view('laraticket::user_tickets', $data);
    	}
    	elseif (auth()->user()->isTicketAdmin()) {
    		$tickets = Ticket::where('status', $status)->latest()->paginate($this->perPage);
    		$data['title'] = $data['breadcrumb'] = "Tickets";
    		$data['tickets'] = $tickets;
    		$data['open_count'] = Ticket::countTickets("open");
    		$data['closed_count'] = Ticket::countTickets("closed");
    		return view('laraticket::user_tickets', $data);
    	}    	
    }

    public function show($slug){
    	$ticket = Ticket::where('slug', $slug)->firstOrFail();
    	$data['title'] = $ticket->title;
    	$data['breadcrumb'] = "View Ticket";
    	$data['ticket'] = $ticket;
    	return view('laraticket::view', $data);
    }

    public function create(){
    	$ticket_options = new TicketOption;
    	$data['categories'] = $ticket_options->getCategories();
    	$data['priorities'] = $ticket_options->getPriorities();
    	$data['breadcrumb'] = $data['title'] = "Create new ticket";

    	return view('laraticket::create', $data);
    }
    public function store(Request $request){
    	$this->validate($request, 
    		['title' => 'required|string|max:255',
    		'body' => 'required',
    		'priority' => 'required|string|max:30',
    		'category' => 'required|string|max:30']);
    	$ticket = new Ticket;
    	$ticket->user_id = auth()->id();
    	$ticket->user_name = auth()->user()->name;
    	$ticket->title = $request->title;
    	$ticket->slug = str_slug($request->title) . str_random(4);
    	$ticket->body = $request->body;
    	$ticket->priority = $request->priority;
    	$ticket->category = $request->category;
    	$ticket->status = "open";
    	$ticket->save();
    	$notification_data = ['message' => auth()->user()->name . " submitted a ticket",
	    	"url" => url("tickets/show/$ticket->slug")];
		// Notification::send( (new User)->getTicketAdmins(), new TicketNotification($ticket, $notification_data));
		event(new TicketSubmitted($ticket));
    	return redirect(url('tickets'))->with(['status' => 'success', 'message' => 'Ticket created, you will be notified when there\'s a reply']);
    	
    }

    public function reply(Request $request, $id){
    	$this->validate($request, [
    		'content' => 'required']);
    	$ticket = Ticket::findOrFail($id);
    	if (auth()->user()->isTicketAdmin() OR $ticket->user_id === auth()->id()){
    		$comment = new TicketComment;
    		$comment->user_id = auth()->id();
    		$comment->ticket_id = $id;
    		$comment->body = $request->content;
			$comment->save();
			event(new TicketReplied($comment));
            return back()->with(['status' => 'success', 'message' => "Comment submitted successfully"]);
    	}
    	else{
            return back()->with(['status' => 'info', 'message' => "You do not have permission to update this ticket"]);
    	}
    }

    public function changeStatus(Request $request, $id){
    	$this->validate($request, [
    		'action' => 'required']); //set array rule to check if action is correct
    	$ticket = Ticket::findOrFail($id);
    	$action = $request->action;

    	if (auth()->user()->isTicketAdmin() OR $ticket->user_id === auth()->id()){
    		switch ($action) {
    			case 'open':
    				$ticket->status = "open";
    				break;
    			case 'close':
    				$ticket->status = "closed";
					$ticket->date_closed = Carbon::now();
    				break;
    			default:
    				$ticket->status = "close";
    				$ticket->date_closed = Carbon::now();
    				break;
    		}
			$ticket->save();
			event(new TicketClosed($ticket));
            return back()->with(['status' => 'success', 'message' => "Ticket status updated successfully"]);
    	}
    	else{
            return back()->with(['status' => 'success', 'message' => "You do not have permission to update this ticket"]);
    	}
    	return back();
    }

    public function delete($ticket){
    	$ticket = Ticket::findOrFail($ticket);
    	if (auth()->user()->isTicketAdmin() OR $ticket->user_id === auth()->id()){
			event(new TicketDeleted($ticket));
    		$ticket->delete();	
            return redirect(url('tickets'))->with(['status' => 'info', 'message' => 'Ticket deleted']);
    	}
    	else{
            return redirect(url('tickets'))->with(['status' => 'info', "message" => "You do not have permission to delete this ticket"]);
    	}
    	return redirect(url('tickets'));
    }

}
