<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', [
    'as' => 'home', 'uses' => 'ClientController@show'
]);

$router->get('/client/{id}/info', [
    'as' => 'client-info', 'uses' => 'ClientController@info'
]);

$router->get('/client/{id}/accounts', [
    'as' => 'client-accounts', 'uses' => 'ClientController@accounts'
]);

$router->get('/client/logout', [
    'as' => 'client-logout', 'uses' => 'ClientController@logout'
]);

$router->post('/client/login', [
    'as' => 'client-login', 'uses' => 'ClientController@login'
]);

$router->get('/client/logout', [
    'as' => 'client-logout', 'uses' => 'ClientController@logout'
]);

$router->post('/client/register', [
    'as' => 'client-register', 'uses' => 'ClientController@register'
]);

$router->get('/client/payees', [
    'as' => 'client-payees', 'uses' => 'ClientController@getPayees'
]);

$router->get('/client/payee/{id}' , [
    'as' => 'client-get-payee', 'uses' => 'ClientController@getPayee'
]);

$router->post('/client/payee', [
    'as' => 'client-add-payee', 'uses' => 'ClientController@addPayee'
]);

$router->delete('/client/payee/{id}', [
    'as' => 'client-delete-payee', 'uses' => 'ClientController@deletePayee'
]);

$router->patch('/client/payee/{id}', [
    'as' => 'client-update-payee', 'uses' => 'ClientController@updatePayee'
]);

$router->get('/branches', [
    'as' => 'branch-list', 'uses' => 'BranchController@getBranches'
]);

$router->post('/branch', [
    'as' => 'branch-post', 'uses' => 'BranchController@addBranch'
]);