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

    /**
     * Returns the information about a client
     * 
     * @param Request $request
     * @return Response
     */
    public function show(Request $request, $id){
        app('session')->put('name', rand());

        //dd(app('session')->all());
        return response()->json(\DB::select("SELECT * FROM `dec353_2`.`client_view`"));
    }

    public function schedule(Request $request) {
        return reponse()->json(\DB::select("SELECT * FROM `employee` WHERE `employee_id` = ?", [$request->session()->get('employee_id')]), 200);
    }

    /**
     * Register a employee to the system.
     * 
     * @param Request $request Request to parse
     * @return Response
     */
    public function register(Request $request) {
        $employee = array();
        $employee_address = array();
        $errors = array();

        // First Name is a required field.
        if(!$request->input('first_name')) {
            $errors[] = ['message' => 'First Name is required'];
        } else {
            $employee['first_name'] = $request->input('first_name');
        }

        if(!$request->input('last_name')) {
            $errors[] = ['message' => 'Last Name is required'];
        } else {
            $employee['last_name'] = $request->input('last_name');
        }

        if(!$request->input('gender')) {
            $client['gender'] = 'U';
        } else {
            $employee['gender'] = $request->input('gender');
        }

        if(!$request->input('phone_number')) {
            $errors[] = ['message' => 'Phone number is required'];
        } else {
            $employee['phone_number'] = $request->input('phone_number');
        }

        if(!$request->input('dob')) {
            $errors[] = ['message' => 'Date of birth is required'];
        } else {
            $employee['dob'] = $request->input('dob');
        }

        if(!$request->input('email')) {
            $errors[] = ['message' => 'Email is required'];
        } else {
            $employee['email'] = $request->input('email');
        }

        if(!$request->input('client_category_id')) {
            $errors[] = ['message' => 'Client category is required'];
        } else {
            $employee['client_category_id'] = $request->input('client_category_id');
        }

        if(!$request->input('password')) {
            $errors[] = ['message' => 'Password is required'];
        } else {
            $employee['password'] = \password_hash($request->input('password'), PASSWORD_DEFAULT);
        }

        if(!$request->input('street')) {
            $errors[] = ['message' => 'Street is required'];
        } else {
            $employee_address['street'] = $request->input('street');
        }

        if($request->input('apt')) {
            $employee_address['apt'] = $request->input('apt');
        }

        if(!$request->input('city')) {
            $errors[] = ['message' => 'City is required'];
        } else {
            $employee_address['city'] = $request->input('city');
        }

        if(!$request->input('postal_code')){
            $errors[] = ['message' => 'Postal code is required'];
        } else {
            $employee_address['postal_code'] = $request->input('postal_code');
        }

        if(!$request->input('province')){
           $errors[] = ['message' => 'Province is required'];
        } else {
            $employee_address['province'] = $request->input('province');
        }

        if (!$request->has('branch_id')) {
            $errors[] = ['message' => 'Branch of employee is required'];
        } else {
            $employee['branch_id'] = $request->input('branch_id');
        }

        if (!$request->has('employee_title_id')) {
            $errors[] = ['message' => 'Employee title is required'];
        } else {
            $employee['employee_title_id'] = $request->input('employee_title_id');
        }

        if (!$request->has('start_date')) {
            $employee['start_date'] = date('Y-m-d');
        } else {
            $employee['start_date'] = $request->input('start_date');
        }

        if(!empty($errors)) {
            return response()->json(['errors' => $errors], 400);
        }

        try{
            \DB::transaction(function () use ($employee, $employee_address) {
                \DB::insert("INSERT INTO `address` (street, apt, city, postal_code, province) VALUES (:street, :apt, :city, :postal_code, :province)", $cemployee_address);

                $employee['address_id'] = \DB::getPdo()->lastInsertId();

                \DB::insert("INSERT INTO `employee` (first_name, last_name, gender, phone_number, dob, email, address_id, password, employee_title_id, start_date) VALUES (:first_name, :last_name, :gender, :phone_number, :dob, :email, :address_id, :password, :employee_title_id, :start_date)", $employee);
            });

            return response()->json(NULL,200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error while creating the employee'], 400);
        }

        return response()->json(NULL, 200);
    }

    public function delete(){

    }

    public function update(){

    }
}
