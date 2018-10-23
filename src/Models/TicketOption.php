<?php

namespace Sdkcodes\LaraTicket\Models;

use Illuminate\Database\Eloquent\Model;

class TicketOption extends Model
{
    protected $fillable = ['key', 'values'];
    public function getCategories(){
    	$first = $this->where('key', 'categories')->first();
    	$categories = $first ? explode(",", $first->values) : [];
    	return $categories;
    }

    public function getPriorities(){
    	$first = $this->where('key', 'priorities')->first();
    	$priorities = $first ? explode(",", $first->values) : [];
    	return $priorities;
    }
}
