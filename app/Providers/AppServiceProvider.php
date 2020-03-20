<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use App\User;
use App\Role;




class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
         Schema::defaultStringLength(191);
         Paginator::defaultView('vendor.pagination.default');
         View::share('status',Config::get('volok.client_status'));
         View::share('sms_status',Config::get('volok.sms_status'));
         View::share('department',Config::get('volok.department'));
         View::share('ticket_status',Config::get('volok.ticket_status'));
         View::share('ticket_type',Config::get('volok.ticket_type'));           
         
         Gate::define('user_manager', function ($user) {        				
			$db_user = \App\User::find($user['id']);
			return $db_user->permissions->contains('kod','user_manager');
		    });       
        Gate::define('check_rights', function ($user, $permission) {
			$db_user = \App\User::find($user['id']);
			return $db_user->permissions->contains('kod',$permission);
    });
    }
}
