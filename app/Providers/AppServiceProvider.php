<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Pagination\Paginator;

use App\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::automaticallyEagerLoadRelationships( );

        //URL::forceScheme('https'); // linux

        if (!App::runningInConsole()) {

            foreach ($this->listPermissions() as $permission) {
                Gate::define($permission->name, function ($user) use ($permission) {
                    return $user->hasRoles($permission->roles);
                });
            }
        }

        Paginator::useBootstrap();
    }

    // listagem de permissões com os dados dos perfis (roles)
    private function listPermissions()
    {
        return Permission::with('roles')->get();
    }
}
