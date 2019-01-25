# LaraTicket
## A Laravel 5 package to handle ticket support system within your project
### About
<hr>
A Laravel 5 package to handle ticket support system within your project. LaraTicket integerates nicely with the existing users database and authentication system. You are also at liberty to configure a number of options to make it match your project more closely.
You can use LaraTicket straight out of the box without extra efforts or configurations

### Features
1. Two main user roles (admin and user)
2. Users can create tickets, add comments, open and close tickets
3. Feature rich text editor with image and video embeding
4. Uses bootstrap 4
5. An easy to use admin panel
6. Custom views, so you do not need to write your own views
7. Custom predefined routes

### Installation
- To install LaraTicket, in your existing project root directory, run
`composer require sdkcodes/lara-ticket 0.0.2`
- If you're using Laravel < 5.4, copy and add this line to the `providers` array in your `config/app.php` file
`Sdkcodes\LaraTicket\LaraTicketServiceProvider::class,`

```
<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Sdkcodes\LaraTicket\Traits\UserTicket;

class User extends Authenticatable
{
    use UserTicket;
    ...
```
- Laravel >= 5.5 auto-discovers the package, so you do not need to add it manually.
- Publish the views, config and migrations with the command 
`php artisan vendor:publish`
- Add this trait to your user model `use UserTicket;`
Don't forget to import the trait `use Sdkcodes\LaraTicket\Traits\UserTicket;`
- ### Configuration
```
return[
    'layout' => 'layouts.front',
    /*
    |--------------------------
    | If you probably need to use a different template layout for the admin part of the ticket
    | you can make change this value to match
    |--------------------------
    */
    'admin_layout' => 'layouts.master',

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
```
You can change the configuration values as needed
- Run `php artisan migrate ` to do the necessary migrations
- LaraTicket alters your users table to add a new column to it `laraticket_admin`. 
- Change the value of this column to true (or 1) to set any user as a ticket admin
- Visit your project url `/tickets` to begin usage.
- Admin can (should) add categories and priorities as needed

### Events
` version 0.0.2 upwards`

This package emits 4 different actions that you can listen for in your app to perform related and necessary actions. These events are:
``` 
    * Sdkcodes\LaraTicket\TicketSubmitted ($ticket object becomes available to your listener)
    * Sdkcodes\LaraTicket\TicketReplied ($comment object becomes available to your listener)
    * Sdkcodes\LaraTicket\TicketClosed ($ticket object becomes available to your listener)
    * Sdkcodes\LaraTicket\TicketDeleted ($ticket object becomes available to your listener)
``` 
With your own listeners, you can decide to do different things like send notifications to concerned parties etc.

E.g
To listen for a `TicketSubmitted` event, add this to your `EventServiceProvider.php`
```
<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Sdkcodes\LaraTicket\Events\TicketSubmitted;
use App\Listeners\SendTicketSubmissionNotification;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        
        TicketSubmitted::class => [
            SendTicketSubmissionNotification::class
        ],
        'Sdkcodes\LaraTicket\Events\TicketDeleted' => [
            'App\Listeners\SendTicketDeletionNotification'
        ],
        'Sdkcodes\LaraTicket\Events\TicketReplied' => [
            'App\Listeners\SendTicketRepliedNotifcation'
        ],
        'Sdkcodes\LaraTicket\Events\TicketClosed' => [
            'App\Listeners\SendTicketClosedNotifcation'
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        
    }
}

```
Your event listener code
```
<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Sdkcodes\LaraTicket\Events\TicketSubmitted;

class SendTicketSubmissionNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $ticket = $event->ticket;
        Log::info("Ticket has been submitted, we can send mail now or anything else");
    }
}

```
### Routes
* Route::get('admin/tickets', "TicketController@index");
* Route::get('tickets/create', "TicketController@create");
* Route::get('tickets/{status?}', "TicketController@index");
* Route::get('tickets/show/{ticket}', "TicketController@show");
* Route::get('tickets/{ticket}/update', "TicketController@changestatus");
* Route::post('tickets/store', "TicketController@store");
* Route::put('tickets/{ticket}', "TicketController@update");
* Route::delete('tickets/{ticket}', "TicketController@delete");
* Route::post('tickets/comments/store/{ticket}', "TicketController@reply");
* Route::get('admin/tickets/options/settings', "TicketOptionController@options");
* Route::post('admin/tickets/options/settings', "TicketOptionController@store");
* Route::put('admin/tickets/options/settings', "TicketOptionController@update");

### Licence
LaraTicket is MIT Licensed. Use and enjoy as you like!