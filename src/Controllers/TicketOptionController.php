<?php

namespace Sdkcodes\LaraTicket\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Sdkcodes\LaraTicket\Models\TicketOption;

class TicketOptionController extends Controller
{
    public function store(Request $request, TicketOption $tOptions){
    	

    	if ($request->categories){
    		$categories = array_filter($request->categories);
    		TicketOption::updateOrCreate(['key' => 'categories'], ['values' => collect($categories)->implode(",")]);	
    		
    	}
    	elseif ($request->priorities) {
    		$priorities = array_filter($request->priorities);
    		TicketOption::updateOrCreate(['key' => 'priorities'], ['values' => collect($priorities)->implode(",")]);
    	}
    	
    	return back()->with(['status' => 'success', 'message' => "Ticket options updated successfully"]);
    	
    }

    public function options(TicketOption $option){
    	$data['categories'] = $option->getCategories();
    	$data['priorities'] = $option->getPriorities();
    	return view('laraticket::options', $data);
    }
}
