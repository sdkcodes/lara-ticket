<?php

return[
	'layout' => 'laraticket::layouts.master',
	/*
	|--------------------------
	| If you probably need to use a different template layout for the admin part of the ticket
	| you can make change this value to match
	|--------------------------
	*/
	'admin_layout' => 'laraticket::layouts.master',
	/*
	|------------------------------------------
	| Set this value to yes to allow admin be able to create tickets too
	| ------------------------------------------
	 */
	'can_admin_create_ticket' => 'no',

	/**
	 * In case your default users tablename is not users
	 * You can change this value to reflect your table name 
	 * This will have an effect in migrations
	 * 
	 * *
	 * */

	'user_table_name' => 'users',

	/**
	 * Change this value if your user model is not located in the laravel's default App directory
	 * 
	 * */
	'user_model_namespace' => 'App\User',

	/**@internal Where should users be taken to when they click on navbar brand
	**/
	'return_url' => 'dashboard',
	/*
	|-----------------------------------------------------------------------
	|Use this to set the number of items returned when retrieving from database
	|For pagination purpose
	|-----------------------------------------------------------------------
	*/
	'per_page' => 20,
	/*
	|--------------------------------------------------------
	|If you have a customised pagination template to use,
	|set it's value here
	|
	*/
	'pagination_view_name' => 'pagination::bootstrap-4'

];