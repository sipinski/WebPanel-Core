<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Generic Requests

Route::get('/',     'WelcomeController@index');
Route::get('home',  'HomeController@index');

//Installer Routes
Route::group(['prefix'=>'installer'],function(){
    Route::get('',          ['as' => 'installer.welcome.show',  'uses' => 'InstallerController@showWelcome']);
    Route::post('',         ['as' => 'installer.welcome.post',  'uses' => 'InstallerController@postWelcome']);
    Route::get('settings',  ['as' => 'installer.settings.show', 'uses' => 'InstallerController@showSettings']);
    Route::post('settings', ['as' => 'installer.settings.post', 'uses' => 'InstallerController@postSettings']);
    Route::get('users',     ['as' => 'installer.users.show',    'uses' => 'InstallerController@showUsers']);
    Route::post('users',    ['as' => 'installer.users.post',    'uses' => 'InstallerController@postUsers']);
    Route::get('finish',    ['as' => 'installer.finish.show',   'uses' => 'InstallerController@showFinish']);
});

//WebPanel Routes
Route::group(['middleware' => ['auth','authorize'], 'prefix'=>'webpanel'],function(){
    Route::get('', ['as' => 'webpanel.dashboard', 'uses' => 'WebPanel\DashboardController@showDashboard']);
    Route::resource('items',        'WebPanel\ItemsController');
    Route::resource('categories',   'WebPanel\CategoriesController');
    Route::resource('users',        'WebPanel\UsersController');
    Route::resource('servers',      'WebPanel\ServersController');

    Route::group(['prefix' => 'versions'],function(){
        Route::get('', ['as' => 'webpanel.versions.index','uses' => 'WebPanel\VersionsController@index']);
        Route::get('/{versions}', ['as' => 'webpanel.versions.show', 'uses' => 'WebPanel\VersionsController@show']);
    });

    Route::group(['prefix' => 'tools'],function(){
        Route::get('json_shrinker', ['as' => 'webpanel.tools.json_shrinker','uses' => 'WebPanel\ToolsController@getJsonShrinker']);
        Route::get('json_checker',  ['as' => 'webpanel.tools.json_checker', 'uses' => 'WebPanel\ToolsController@getJsonChecker']);
        Route::get('impex',         ['as' => 'webpanel.tools.impex', 'uses' => 'WebPanel\ToolsController@getImpex']);
    });

});


//Auth Routes

Route::get('/logout',['as'=>'logout','uses' => 'Auth\AuthController@getLogout']);
Route::get('/login', ['as'=>'login' ,'uses' => 'Auth\AuthController@getLogin']);

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);



// Test Routes

Route::get('testpromote',function()
{
	$owner = new App\Role();
	$owner->name         = 'owner';
	$owner->display_name = 'Project Owner'; // optional
	$owner->description  = 'User is the owner of a given project'; // optional
	$owner->save();

	$admin = new App\Role();
	$admin->name         = 'admin';
	$admin->display_name = 'User Administrator'; // optional
	$admin->description  = 'User is allowed to manage and edit other users'; // optional
	$admin->save();

	return "done";
});

Route::get('testadminlte',['as' => 'temp', function()
{
    return View::make('templates.adminlte205.webpanel.empty');
}]);