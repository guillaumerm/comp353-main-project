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


$router->group(['prefix' => 'api'], function ($router) {
    $router->get('/client/info', [
        'as' => 'client-info', 'uses' => 'ClientController@info'
    ]);

    $router->post('/employee/login', [
        'as' => 'employee-login', 'uses' => 'EmployeeController@login'
    ]);

    $router->get('/employee/schedule', [
        'as' => 'employee-schedule', 'uses' => 'EmployeeController@getSchedule'
    ]);
    
    $router->get('/client/accounts', [
        'as' => 'client-accounts', 'uses' => 'ClientController@accounts'
    ]);

    $router->post('/client/account', [
        'as' => 'client-post-account', 'uses' => 'ClientController@createAccount'
    ]);

    $router->post('/client/transfermoney', [
        'as' => 'client-transfer-money', 'uses' => 'ClientController@transferBetweenAccounts'
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

    $router->post('/employee/register', [
        'as' => 'employee-register', 'uses' => 'EmployeeController@register'
    ]);
    
    $router->get('/client/payees', [
        'as' => 'client-payees', 'uses' => 'ClientController@getPayees'
    ]);

    $router->post('/client/payment', [
        'as' => 'client-bill', 'uses' => 'ClientController@makePayment'
    ]);
    
    $router->post('/client/payee', [
        'as' => 'client-add-payee', 'uses' => 'ClientController@addPayee'
    ]);

    $router->post('/client/sendfund', [
        'as' => 'client-send-fund', 'uses' => 'ClientController@sendFund'
    ]);

    $router->get('/client/awaitingFunds', [
        'as' => 'client-awaiting-funds', 'uses' => 'ClientController@awaitingFunds'
    ]);

    $router->post('/client/receiveFunds', [
        'as' => 'client-received-funds', 'uses' => 'ClientController@receiveFund'
    ]);

    $router->get('/branches', [
        'as' => 'branch-list', 'uses' => 'BranchController@getBranches'
    ]);
    
    $router->post('/branch', [
        'as' => 'branch-post', 'uses' => 'BranchController@addBranch'
    ]);

    $router->get('/services', [
        'as' => 'services', 'uses' => 'ClientController@getServices'
    ]);

    $router->get('/account/option/{accountOptionId}/chargeplans', [
        'as' => 'client-get-chargeplans', 'uses' => 'ClientController@getChargePlans'
    ]);

    $router->get('/account/types', [
        'as' => 'client-get-types', 'uses' => 'ClientController@getAccountTypes'
    ]);

    $router->get('/account/type/{accountTypeId}/options', [
        'as' => 'client-get-optons', 'uses' => 'ClientController@getAccountOptions'
    ]);

    $router->get('/employee/pays', [
        'as' => 'employee-get-pays', 'uses' => 'EmployeeController@getPays'
    ]);

    $router->get('/finance/report', [
        'as' => 'finance-get-report', 'uses' => 'FinancesController@getReport'
    ]);
});

$router->get('/{route:.*}/', function ()  {
    return view('app');
});