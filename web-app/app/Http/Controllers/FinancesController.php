<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FinancesController extends Controller
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

    public function getReport(Request $request) {
        if(!$request->session()->has('employee_id')) {
            return response()->json(NULL, 404);
        }

        $lossPerCity = \DB::select("select city, sum(amount)*-percentage from (select account_no, percentage, branch_id, account_type_id, city, transaction_no, date, amount from address NATURAL JOIN branch NATURAL JOIN branchAcc NATURAL JOIN account NATURAL JOIN account_type NATURAL JOIN interest_rate NATURAL JOIN transaction)CT where percentage != 0 AND CT.date >= (select DATE_SUB(\"2019-01-01\", INTERVAL 12 MONTH)) AND CT.account_type_id = 2");
        $profit = \DB::select("select branch_id, SUM(amount)*-percentage from (select * from(select account_no, percentage, branch_id from branch NATURAL JOIN branchAcc NATURAL JOIN account NATURAL JOIN account_type NATURAL JOIN interest_rate where interest_rate.account_type_id = account_type.account_type_id AND account_type.account_type_id != 1)ABE NATURAL JOIN transaction T)KIKI where date >= (select DATE_SUB(\"2019-01-01\", INTERVAL 12 MONTH))");
        $yearlyLoss = \DB::select("select branch_id, SUM(amount)*-percentage from (select * from(select account_no, percentage, branch_id, account_type_id from branch NATURAL JOIN branchAcc NATURAL JOIN account NATURAL JOIN account_type NATURAL JOIN interest_rate where interest_rate.account_type_id = account_type.account_type_id AND account_type.account_type_id != 1)ABE NATURAL JOIN transaction T)KIKI where date >= (select DATE_SUB(\"2019-01-01\", INTERVAL 12 MONTH)) AND account_type_id = 2");
        $profitPerBranch = \DB::select("select branch_id, SUM(amount)*-percentage from (select * from(select account_no, percentage, branch_id from branch NATURAL JOIN branchAcc NATURAL JOIN account NATURAL JOIN account_type NATURAL JOIN interest_rate where interest_rate.account_type_id = account_type.account_type_id AND account_type.account_type_id != 1)ABE NATURAL JOIN transaction T)KIKI where date >= (select DATE_SUB(\"2019-01-01\", INTERVAL 12 MONTH))");
        $profitPerCity = \DB::select("select city, sum(amount)*-percentage from (select account_no, percentage, branch_id, account_type_id, city, transaction_no, date, amount from address NATURAL JOIN branch NATURAL JOIN branchAcc NATURAL JOIN account NATURAL JOIN account_type NATURAL JOIN interest_rate NATURAL JOIN transaction)CT where percentage != 0 AND CT.date >= (select DATE_SUB(\"2019-01-01\", INTERVAL 12 MONTH))");
        $response = [
            ['title' => 'Loss Per City', 'value' => $lossPerCity],
            ['title' => 'Profit', 'value' => $profit],
            ['title' => 'Yearly Loss', 'value' => $yearlyLoss],
            ['title' => 'Profit Per Branch', 'value' => $profitPerBranch],
            ['title' => 'Profit Per City', 'value' => $profitPerBranch]
        ];

        return response()->json($response, 200);
    }
}
