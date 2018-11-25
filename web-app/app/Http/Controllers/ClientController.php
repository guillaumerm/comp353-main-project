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
        if(!$request->input('identity') || !$request->input('password')){
            return response()->json(['error' => ['message' => 'Missing content in your body request']], 400);
        }

        $result = \DB::select("SELECT client_id, password FROM `client` WHERE `client`.`email` = \"" . $request->input("identity") . "\"");
        if(empty($result)){
            return response()->json(NULL, 400);
        }

        if (!\password_verify($request->input("password"), $result[0]->password)){
            return response()->json(['error' => ['message' => 'Incorrect login credentials']], 400);
        } else {
            $request->session()->put('client_id', $result[0]->client_id);
            $request->session()->put('is_employee', false);
            return response()->json(NULL, 200);
        }
    }

    public function getChargePlans(Request $request, $accountOptionId) {
        if(!$request->session()->has('client_id')){
            return response()->json(['error' => 'Authentication is required'], 400);
        }

        $result = \DB::select("SELECT * FROM charge_plan WHERE option_id = ?", [$accountOptionId]);

        return response()->json($result, 200);
    }

    public function getAccountOptions(Request $request, $accountTypeId) {
        if(!$request->session()->has('client_id')) {
            return response()->json(['error' => 'Authentication is required'], 400);
        }

        $result = \DB::select("SELECT * FROM account_option WHERE account_type_id = ?", [$accountTypeId]);

        return response()->json($result, 200);
    } 

    public function getAccountTypes(Request $request) {
        if(!$request->session()->has('client_id')) {
            return response()->json(['error' => 'Authentication is required'], 400);
        }

        $result = \DB::select("SELECT * FROM account_type");

        return response()->json($result, 200);
    }

    /**
     * Logout the current user.
     * 
     * @param Request $request 
     * @return Response 
     */
    public function logout(Request $request) {
        if (!$request->session()->has('client_id') && !$request->session()->has('employee_id')) {
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
        } else {
            $client_address['apt'] = NULL;
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
            \DB::transaction(function () use ($client, $client_address, $request) {
                \DB::insert("INSERT INTO `address` (street, apt, city, postal_code, province) VALUES (:street, :apt, :city, :postal_code, :province)", $client_address);

                $client['address_id'] = \DB::getPdo()->lastInsertId();

                // Automatically login the user once he/she created
                $request->session()->put('client_id', \DB::getPdo()->lastInsertId());

                \DB::insert("INSERT INTO `client` (first_name, last_name, gender, phone_number, dob, email, client_category_id, address_id, password, joining_date) VALUES (:first_name, :last_name, :gender, :phone_number, :dob, :email, :client_category_id, :address_id, :password, :joining_date)", $client);
            });
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
    public function accounts(Request $request){
        if(!$request->session()->has('client_id')) {
            return response()->json(NULL,400);
        }

        $accounts = \DB::select("SELECT * FROM `account` NATURAL JOIN `account_type` NATURAL JOIN `account_option` JOIN `charge_plan` ON `charge_plan`.`charge_plan_no` = `account`.`charge_plan_no` AND `charge_plan`.`option_id` = `account`.`account_option_id` WHERE `account`.`client_id` = :id", [ 'id' => $request->session()->get('client_id')]);

        if ($accounts) {
            foreach($accounts as $account) {
                $account->transactions = \DB::select("SELECT * FROM `transaction` WHERE `transaction`.`account_no` = :account_no AND `transaction`.`date` >= DATE_SUB(NOW(),INTERVAL 10 YEAR)", ['account_no' => $account->account_no]);
            }
        } 
        return response()->json($accounts);
    }

    public function createAccount(Request $request) {
        $errors = array();
        $account ['client_id'] = $request->session()->get('client_id');

        if (!$request->has('account_type_id')) {
            $errors[] = ['message' => 'Account type is required'];
        } else {
            $account['account_type_id'] = $request->input('account_type_id');
        }

        if (!$request->has('account_option_id')) {
            $errors[] = ['message' => 'Account option is required'];
        } else {
            $account['account_option_id'] = $request->input('account_option_id');
        }

        if (!$request->has('charge_plan_no')) {
            $errors[] = ['message' => 'Charge plane number is required'];
        } else {
            $account['charge_plan_no'] = $request->input('charge_plan_no');
        }

        if (!$request->has('branch_id')) {
            $errors[] = ['message' => 'Location of account is required'];
        } else {
            $account['branch_id'] = $request->input('branch_id');
        }

        if(!$request->has('service_id')) {
            $errors[] = ['message' => 'Service type of the account is required'];
        } else {
            $account['service_id'] = $request->input('service_id');
        }

        try{
            \DB::transaction(function () use ($account) {
                
                $result = \DB::insert("INSERT INTO `account` (`client_id`, `account_type_id`, `account_option_id`, `charge_plan_no`) VALUES (:client_id, :account_type_id, :account_option_id, :charge_plan_no)", $account);
                
                if(!$result) {
                    throw new Exception();
                }

                $account['account_no'] = \DB::getPdo()->lastInsertId();
                
                \DB::insert("INSERT INTO `branchAcc` (`account_no`, `branch_id`, `service_id`) VALUES (:account_no, :branch_id, :service_id)", $account);
                
                if(!$result) {
                    throw new Exception();
                }
            });
        } catch (Exception $e) {
            return response()->json(['error' => 'Error while creating the account'], 400);
        }
        
        return response()->json(NULL,200);
    }

    public function getPayees(Request $request) {
        if(!$request->session()->has('client_id')) {
            return response()->json(NULL,400);
        }

        return response()->json(\DB::select("SELECT * FROM `payee` WHERE `payee`.`client_id` = ?", [ $request->session()->get('client_id') ]));
    }

    public function addPayee(Request $request) {
        $errors = array();
        $payee = array();
        if(!$request->input('name')) {
            $errors[] = ['message' => 'Name of the payee is required'];
        } else {
            $payee ['name'] = $request->input('name'); 
        }

        if($request->input('account_no')) {
            $errors[] = ['message' => 'Account no of payee is required'];
        } else {
            $payee ['account_no'] = $request->input('account_no');
        }

        $result = \DB::insert("INSERT INTO payee (name, account_no, client_id) VALUES (?, ?, ?)", [$request->input('name'), $request->input('account_no'), $request->session()->get('client_id')]);

        if(!$result) {
            return response()->json(NULL, 400);
        } else {
            return response()->json(NULL, 200);
        }
    }

    public function updatePayee(Request $request, $id) {
        $payee = [ 'payee_id' => $id ];

        $payee['name'] = $request->input('name');
        $payee['account_no'] = $request->input('account_no');

        $result = \DB::update("UPDATE `payee` SET `payee`.`name` = :name AND `payee`.`account_no` = :account_no", $payee);

        if(!$result) {
            return response()->json(NULL, 400);
        } else {
            return response()->json(NULL, 200);
        }
    }

    public function deletePayee(Request $request, $id) {
        $errors = array();
        $result = \DB::delete("DELETE FROM `payee` WHERE `payee`.`client_id` = :client_id AND `payee`.`payee_id` = :payee_id", ['client_id' => $request->session()->get("client_id"), 'payee_id' => $id]);
    
        if(!$result) {
            return response()->json(NULL, 400);
        } else {
            return response()->json(NULL, 200);
        }
    }

    public function makePayment(Request $request) {
        $payments = $request->input();

        if (empty($payments)){
            return response()->json(NULL, 200);
        }

        foreach($payments as $payment){
            try{
                \DB::transaction(function () use ($payment, $request) {
                    $result = \DB::update("UPDATE `account` SET `account`.`balance` =  `account`.`balance` - ? WHERE `account`.`account_no` = ? AND `account`.`client_id` = ?", [$payment['amount'], $payment['from_account_no'], $request->session()->get('client_id')]);
    
                    if (!$result) {
                        throw new Execption();
                    }
    
                    $result = \DB::insert("INSERT INTO `transaction` (`account_no`, date, `amount`) VALUES (?, ?, (-1)*?)", [$payment['from_account_no'], date('Y-m-d'), $payment['amount']]);
    
                    if (!$result) {
                        throw new Execption();
                    }
    
                    $result = \DB::insert("INSERT INTO `bill_payment` (`payee_id`, `amount`, `date`, `from_account_no`) VALUES (?, ?, ?, ?)", [$payment['payee_id'], $payment['amount'], date('Y-m-d'), $payment['from_account_no']]);
    
                    if (!$result) {
                        throw new Exeception();
                    }
                });
    
                return response()->json(NULL,200);
            } catch (Exception $e) {
                return response()->json(['error' => 'Error while making the payment'], 400);
            }
        }

        return response()->json(NULL, 200);

    }

    public function awaitingFunds(Request $request) {
        return response()->json(\DB::select("SELECT `fund_transfer`.`date_sent`, `fund_transfer`.`fund_transfer_id`, `client`.`first_name`, `client`.`last_name`, `fund_transfer`.`amount` FROM `fund_transfer` JOIN `client` ON `client`.`client_id` = `fund_transfer`.`from_client_id` WHERE `fund_transfer`.`to_client_id` = ? AND `fund_transfer`.`date_received` IS NULL", [$request->session()->get('client_id')]), 200);
    }

    public function receiveFund(Request $request) {
        $transfer = array();

        if (!$request->has('to_account_no')){
            return response()->json(['error' => 'Destination account number is required'], 400);
        }

        if (!$request->has('fund_transfer_id')) {
            return response()->json([ 'error' => 'Fund transfer id is required'], 400);
        }

        $result = \DB::select("SELECT * FROM `fund_transfer` WHERE `fund_transfer`.`fund_transfer_id` = ? AND `fund_transfer`.`date_received` IS NULL", [$request->input('fund_transfer_id')]);

        if (!$result) {
            return response()->json(['error' => 'Fund transfer not found'], 400);
        }
        $result = $result[0];

        $result->to_account_no = $request->input('to_account_no');
        $result->date_received = date('Y-m-d');

        try{
            \DB::transaction(function () use ($result) {
                \DB::update("UPDATE `account` SET `account`.`balance` = `account`.`balance` + ? WHERE `account`.`account_no` = ? AND `account`.`client_id` = ?", [$result->amount, $result->to_account_no, $result->to_client_id]);

                \DB::insert("INSERT INTO `transaction` (`account_no`, `date`, `amount`) VALUES (?, ?, ?)", [$result->to_account_no, $result->date_received, $result->amount]);

                \DB::update("UPDATE `fund_transfer` SET `date_received` = ?, `to_account_no` = ? WHERE `fund_transfer_id` = ?", [$result->date_received, $result->to_account_no, $result->fund_transfer_id]);
            });
        } catch (Exception $e) {
            return response()->json(['error' => 'Error while making the transfer'], 400);
        }

        return response()->json(NULL,200);
    }

    public function sendFund(Request $request) {
        $transfer = array();
        $to_client = array();
        $transfer['from_client_id'] = $request->session()->get('client_id');
        $transfer['date_sent'] = date('Y-m-d');
        if($request->has('phone')){
            $to_client = \DB::select("SELECT * FROM `client` WHERE `client`.`phone` = ?", [$request->input('phone')]);
        } else if ($request->has('email')) {
            $to_client = \DB::select("SELECT * FROM `client` WHERE `client`.`email` = ?", [$request->input('email')]);
        } else {
            return response()->json(['error' => 'Phone or email is required'], 400);
        }

        if (!$to_client) {
            return response()->json(['error' => 'No client has the email or phone provided'], 400);
        } else {
            $transfer['to_client_id'] = $to_client[0]->client_id;
        }

        if(!$request->has('amount')) {
            return response()->json(['error' => 'Amount is required'], 400);
        } else {
            $transfer['amount'] = $request->input('amount');
        }

        if (!$request->has('from_account_no')) {
            return response()->json(['error' => 'Originating account number is required'], 400);
        } else {
            $transfer['from_account_no'] = $request->input('from_account_no');
        }

        try{
            \DB::transaction(function () use ($transfer) {
                $result = \DB::update("UPDATE `account` SET `account`.`balance` = `account`.`balance` - ? WHERE `account`.`account_no` = ? AND `account`.`client_id` = ?", [$transfer['amount'], $transfer['from_account_no'], $transfer['from_client_id']]);

                $result = \DB::insert("INSERT INTO `transaction` (`account_no`, `date`, `amount`) VALUES (?, ?, (-1)*?)", [$transfer['from_account_no'], $transfer['date_sent'], $transfer['amount']]);

                $result = \DB::insert("INSERT INTO `fund_transfer` (`from_client_id`, `to_client_id`, `date_sent`, `from_account_no`, `amount`) VALUES (?, ?, ?, ?, ?)", [$transfer['from_client_id'], $transfer['to_client_id'], $transfer['date_sent'], $transfer['from_account_no'], $transfer['amount']]);
            });
        } catch (Exception $e) {
            return response()->json(['error' => 'Error while making the transfer'], 400);
        }
        return response()->json(NULL,200);
    }

    public function transferBetweenAccounts(Request $request) {
        $errors = array();
        $transfer = array();

        if(!$request->input('from_account_no')) {
            $errors[] = ['message' => 'Originating account number is required (from_account_no)'];
        } else {
            $transfer['from_account_no'] = $request->input('from_account_no');
        }

        if(!$request->input('to_account_no')) {
            $errors[] = ['message' => 'Desitnation account number is required (to_account_no)'];
        } else {
            $transfer['to_account_no'] = $request->input('to_account_no');
        }
        
        if(!$request->input('amount')){
            $errors[] = ['message' => 'Amount is required (amount)'];
        } else {
            $transfer['amount'] = $request->input('amount');
        }

        $transfer['client_id'] = $request->session()->get('client_id');
        try{
            \DB::transaction(function () use ($transfer) {
                $result = \DB::update("UPDATE `account` SET `account`.`balance` =  `account`.`balance` - ? WHERE `account`.`account_no` = ? AND `account`.`client_id` = ?", [$transfer['amount'], $transfer['from_account_no'], $transfer['client_id']]);
                
                $result = \DB::insert("INSERT INTO `transaction` (`account_no`, `date`, `amount`) VALUES (?, ?, ?)", [$transfer['from_account_no'], date('Y-m-d'), (-1)*$transfer['amount']]);

                $result = \DB::update("UPDATE `account` SET `account`.`balance` =  `account`.`balance` + ? WHERE `account`.`account_no` = ? AND `account`.`client_id` = ?", [$transfer['amount'], $transfer['to_account_no'], $transfer['client_id']]);
 
                $result = \DB::insert("INSERT INTO `transaction` (`account_no`, `date`, `amount`) VALUES (?, ?, ?)", [$transfer['to_account_no'], date('Y-m-d'), $transfer['amount']]);
            });

            return response()->json(NULL,200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error while making the transfer'], 400);
        }
    }

    public function getServices() {
        $result = \DB::select("SELECT * FROM service");
        return response()->json($result, 200);
    }

    public function delete($request, $id){
        $result = \DB::delete("DELETE FROM `client` WHERE `client`.`client_id` = :id", ["id" => $id]);

        if (!$result) {
            return response()->json(['error' => 'Error while deleting the user'], 400);
        } else {
            return response()->json(NULL, 200);
        }
    }

    public function update(){

    }
}
