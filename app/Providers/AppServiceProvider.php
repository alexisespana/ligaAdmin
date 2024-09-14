<?php

namespace App\Providers;

use App\Models\Roles\Roles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

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
        $baseUrl = env('API_ENDPOINT');

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.inicio', function ($view) {
            $menusAsignados = Roles::with(['Menu.MenuPadre', 'Menu' => function ($query) {
                $query->select('tipo', 'nombre', 'href', 'id_menupadre', 'orden')->orderBy('orden');
            }])->first();

            $allMenu = [];
            foreach ($menusAsignados->Menu as $key => $benf) {
                //Recorremos los datos del array y si no es null agrupamos por anio
                if (!is_null($menusAsignados->Menu[$key])) {
                    $menu = $benf->MenuPadre->nombre;


                    $allMenu[$menu][] = $benf;
                }
            }
            $menusAsignados = $allMenu;

            // dd($menusAsignados);
            $view->with('menus', ['menus' => $menusAsignados]);
        });
    }
}
