<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SetorController;
use App\Http\Controllers\ObjetoController;
use App\Http\Controllers\ArpController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CotaController;
use App\Http\Controllers\MapaController;
use App\Http\Controllers\ImportController;



# about page
Route::get('/about', function () {
    return view('about.about');
})->name('about')->middleware('auth');

Route::get('/', function () {
    #if the user is logged return index view, if not logged return login view
    if (Auth::check()) {
        return view('index');
    } else {
        return view('auth.login');
    }
});

Auth::routes(['verify' => false, 'register' => false, 'reset' => false]);

Route::get('/profile', [ProfileController::class, 'show'])->name('profile')->middleware('auth');
Route::post('/profile/update/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update')->middleware('auth');
Route::post('/profile/update/theme', [ProfileController::class, 'updateTheme'])->name('profile.theme.update')->middleware('auth');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

# Permission::class

Route::get('/permissions/export/csv', [PermissionController::class, 'exportcsv'])->name('permissions.export.csv')->middleware('auth');

Route::get('/permissions/export/xls', [PermissionController::class, 'exportxls'])->name('permissions.export.xls')->middleware('auth'); // Export XLS

Route::get('/permissions/export/pdf', [PermissionController::class, 'exportpdf'])->name('permissions.export.pdf')->middleware('auth'); // Export PDF

Route::resource('/permissions', PermissionController::class)->middleware('auth');

# Role::class

Route::get('/roles/export/csv', [RoleController::class, 'exportcsv'])->name('roles.export.csv')->middleware('auth'); // Export CSV

Route::get('/roles/export/xls', [RoleController::class, 'exportxls'])->name('roles.export.xls')->middleware('auth'); // Export XLS

Route::get('/roles/export/pdf', [RoleController::class, 'exportpdf'])->name('roles.export.pdf')->middleware('auth'); // Export PDF

Route::resource('/roles', RoleController::class)->middleware('auth');

# User::class

Route::get('/users/export/csv', [UserController::class, 'exportcsv'])->name('users.export.csv')->middleware('auth'); // Export CSV

Route::get('/users/export/xls', [UserController::class, 'exportxls'])->name('users.export.xls')->middleware('auth'); // Export XLS

Route::get('/users/export/pdf', [UserController::class, 'exportpdf'])->name('users.export.pdf')->middleware('auth'); // Export PDF

Route::resource('/users', UserController::class)->middleware('auth');

# Log::class

Route::resource('/logs', LogController::class)->middleware('auth')->only('show', 'index');

# Setor::class

Route::get('/setors/export/xls', [SetorController::class, 'exportxls'])->name('setors.export.xls')->middleware('auth'); // Export CSV

Route::get('/setors/export/csv', [SetorController::class, 'exportcsv'])->name('setors.export.csv')->middleware('auth'); // Export CSV

Route::get('/setors/export/pdf', [SetorController::class, 'exportpdf'])->name('setors.export.pdf')->middleware('auth'); // Export PDF

Route::get('/setors/autocomplete', [SetorController::class, 'autocomplete'])->name('setors.autocomplete')->middleware('auth');

Route::resource('/setors', SetorController::class)->middleware('auth');

# Objeto::class

Route::get('/objetos/export/xls', [ObjetoController::class, 'exportxls'])->name('objetos.export.xls')->middleware('auth'); // Export CSV

Route::get('/objetos/export/csv', [ObjetoController::class, 'exportcsv'])->name('objetos.export.csv')->middleware('auth'); // Export CSV

Route::get('/objetos/export/pdf', [ObjetoController::class, 'exportpdf'])->name('objetos.export.pdf')->middleware('auth'); // Export PDF

Route::get('/objetos/autocomplete', [ObjetoController::class, 'autocomplete'])->name('objetos.autocomplete')->middleware('auth');

Route::resource('/objetos', ObjetoController::class)->middleware('auth');

# Arp::class

Route::get('/arps/export/csv', [ArpController::class, 'exportcsv'])->name('arps.export.csv')->middleware('auth'); // Export CSV

Route::get('/arps/export/pdf', [ArpController::class, 'exportpdf'])->name('arps.export.pdf')->middleware('auth'); // Export PDF

Route::resource('/arps', ArpController::class)->middleware('auth');

# Item::class

Route::post('/items/create', [ItemController::class, 'store'])->name('items.store')->middleware('auth');
Route::post('/items/remove', [ItemController::class, 'destroy'])->name('items.destroy')->middleware('auth');
Route::post('/items/edit', [ItemController::class, 'update'])->name('items.update')->middleware('auth');

# Cota::class

Route::post('/cotas/create', [CotaController::class, 'store'])->name('cotas.store')->middleware('auth');
Route::post('/cotas/remove', [CotaController::class, 'destroy'])->name('cotas.destroy')->middleware('auth');
Route::post('/cotas/edit', [CotaController::class, 'update'])->name('cotas.update')->middleware('auth');

# mapa routes

Route::resource('/mapas', MapaController::class)->middleware('auth');

# import routes
Route::resource('/imports', ImportController::class)->middleware('auth')->only(['index', 'show', 'create', 'store']);
