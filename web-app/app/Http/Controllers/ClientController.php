<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function login(Request $request) {
        if(!$request->input('email') || !$request->input('password')){
            return response()->json(['error' => ['message' => 'Missing content in your body request']], 400);
        }

        $result = \DB::select("SELECT client_id, password FROM `client` WHERE `client`.`email` = \"" . $request->input("email") . "\"");
        
        if (count($result) > 1 || !\password_verify($request->input("password"), $result[0]->password)){
            return response()->json(['error' => ['message' => 'Incorrect login credentials']], 400);
        } else {
            $request->session()->put('client_id', $result[0]->client_id);
            $request->session()->put('is_employee', false);
            return response()->json(NULL, 200);
        }
    }

    /**
     * Logout the current user.
     * 
     * @param Request $request 
     * @return Response 
     */
    public function logout(Request $request) {
        if (!$request->session()->has('client_id')) {
            return response()->json(NULL, 404);
        }

        $request->session()->forget('client_id');
        $request->session()->flush();
    }

    /**
     * Register a client to the system.
     * 
     * @param Request $request Request to parse
     * @return Response
     */
    public function register(Request $request) {
        $client = array();
        $client_address = array();
        $errors = array();

        // First Name is a required field.
        if(!$request->input('first_name')) {
            $errors[] = ['message' => 'First Name is required'];
        } else {
            $client['first_name'] = $request->input('first_name');
        }

        if(!$request->input('last_name')) {
            $errors[] = ['message' => 'Last Name is required'];
        } else {
            $client['last_name'] = $request->input('last_name');
        }

        if(!$request->input('gender')) {
            $client['gender'] = 'U';
        } else {
            $client['gender'] = $request->input('gender');
        }

        if(!$request->input('phone_number')) {
            $errors[] = ['message' => 'Phone number is required'];
        } else {
            $client['phone_number'] = $request->input('phone_number');
        }

        if(!$request->input('dob')) {
            $errors[] = ['message' => 'Date of birth is required'];
        } else {
            $client['dob'] = $request->input('dob');
        }

        if(!$request->input('email')) {
            $errors[] = ['message' => 'Email is required'];
        } else {
            $client['email'] = $request->input('email');
        }

        if(!$request->input('client_category_id')) {
            $errors[] = ['message' => 'Client category is required'];
        } else {
            $client['client_category_id'] = $request->input('client_category_id');
        }

        if(!$request->input('password')) {
            $errors[] = ['message' => 'Password is required'];
        } else {
            $client['password'] = \password_hash($request->input('password'), PASSWORD_DEFAULT);
        }

        if(!$request->input('street')) {
            $errors[] = ['message' => 'Street is required'];
        } else {
            $client_address['street'] = $request->input('street');
        }

        if($request->input('apt')) {
            $client_address['apt'] = $request->input('apt');
        }

        if(!$request->input('city')) {
            $errors[] = ['message' => 'City is required'];
        } else {
            $client_address['city'] = $request->input('city');
        }

        if(!$request->input('postal_code')){
            $errors[] = ['message' => 'Postal code is required'];
        } else {
            $client_address['postal_code'] = $request->input('postal_code');
        }

        if(!$request->input('province')){
           $errors[] = ['message' => 'Province is required'];
        } else {
            $client_address['province'] = $request->input('province');
        }

        $client['joining_date'] = date('Y-m-d');

        if(!empty($errors)) {
            return response()->json(['errors' => $errors], 400);
        }

        try{
            \DB::transaction(function () use ($client, $client_address) {
                \DB::insert("INSERT INTO `address` (street, apt, city, postal_code, province) VALUES (:street, :apt, :city, :postal_code, :province)", $client_address);

                $client['address_id'] = \DB::getPdo()->lastInsertId();

                \DB::insert("INSERT INTO `client` (first_name, last_name, gender, phone_number, dob, email, client_category_id, address_id, password, joining_date) VALUES (:first_name, :last_name, :gender, :phone_number, :dob, :email, :client_category_id, :address_id, :password, :joining_date)", $client);
            });
                            
            // Automatically login the user once he/she created
            app('session')->put('client_id', \DB::getPdo()->lastInsertId());

            return response()->json(NULL,200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error while creating the account'], 400);
        }

        return response()->json(NULL, 200);
    }

    /**
     * Returns the information about a client
     * 
     * @param Request $request
     * @return Response
     */
    public function info(Request $request, $id){
        if(!$request->session()->has('client_id') && !$request->session()->has('employee_id')) {
            return response()->json(NULL,400);
        }

        if($request->session()->has('client_id') && $request->session()->get('client_id') != $id) {
            return response()->json(['error' => ['message' => 'Not allowed']], 400);
        }

        return response()->json(\DB::select("SELECT * FROM `dec353_2`.`client_view` WHERE `client_view`.`client_id` = :id", [ 'id' => $id])[0]);
    }

    /**
     * Returns all the account for a client
     * 
     * @param Request $request
     * @return Response
     */
    public function accounts(Request $request, $id){
        if(!$request->session()->has('client_id') && !$request->session()->has('employee_id')) {
            return response()->json(NULL,400);
        }

        if($request->session()->has('client_id') && $request->session()->get('client_id') != $id) {
            return response()->json(['error' => ['message' => 'Not allowed']], 400);
        }

        return response()->json(\DB::select("SELECT * FROM `account` JOIN `account_type` ON `account_type`.`account_type_id` = `account`.`account_type_id` JOIN `account_option` ON `account`.`account_option_id` = `account_option`.`account_option_id` JOIN `charge_plan` ON `charge_plan`.`charge_plan_no` = `account`.`charge_plan_no` WHERE `account`.`client_id` = :id", [ 'id' => $id]));
    }

    public function delete(){

    }

    public function update(){

    }
}
