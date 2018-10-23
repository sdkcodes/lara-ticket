<?php

namespace Sdkcodes\LaraTicket\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public static function countTickets($status="all"){
        if ($status === "all"){
            return self::count();
        }
        return self::where('status', $status)->count();
    }

    public function comments(){
    	return $this->hasMany(TicketComment::class);
    }

    public function isOpen(){
    	return $this->status === "open";
    }

    public function isClosed(){
    	return $this->status === "closed";
    }

    public function owner(){
        
        return $this->belongsTo(config('laraticket.user_model_namespace'), 'user_id');
    }
}
