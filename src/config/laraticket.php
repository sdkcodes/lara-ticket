<?php

return[
	'layout' => 'laraticket::layouts.master',
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
	'return_url' => 'dashboard'
];