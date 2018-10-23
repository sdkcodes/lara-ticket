<?php

namespace Sdkcodes\LaraTicket\Models;

use Illuminate\Database\Eloquent\Model;

class TicketComment extends Model
{
    public function ticket(){
    	return $this->belongsTo(Ticket::class);
    }

    public function user(){
    	return $this->belongsTo(config('laraticket.user_model_namespace'));
    }
}
