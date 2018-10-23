<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Sdkcodes\LaraTicket\Models\TicketOption;

class CreateTicketOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_options', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key');
            $table->string('values')->nullable();
            // $table->string('categories')->default("one,two,three")->nullable();
            // $table->string('priorities')->default("high,medium,low")->nullable();
            $table->timestamps();
        });
        TicketOption::create(['key' => 'Categories']);
        TicketOption::create(['key' => 'Priorities']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_options');
    }
}
