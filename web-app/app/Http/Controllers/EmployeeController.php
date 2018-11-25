<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
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

    public function login(Request $request) {
        if(!$request->input('identity') || !$request->input('password')){
            return response()->json(['error' => ['message' => 'Missing content in your body request']], 400);
        }

        $result = \DB::select("SELECT employee_id, password FROM `employee` WHERE `employee`.`email` = \"" . $request->input("identity") . "\"");
        if(empty($result)){
            return response()->json(NULL, 400);
        }

        if (!\password_verify($request->input("password"), $result[0]->password)){
            return response()->json(['error' => ['message' => 'Incorrect login credentials']], 400);
        } else {
            $request->session()->put('employee_id', $result[0]->employee_id);
            return response()->json(NULL, 200);
        }
    }

    public function getSchedule(Request $request) {
        return response()->json(\DB::select("SELECT * FROM `schedule` WHERE `employee_id` = ? AND date >= NOW()", [$request->session()->get('employee_id')]), 200);
    }

    public function getPays(Request $request){
        if(!$request->session()->has('employee_id')){
            return response()->json(NULL, 400);
        }

        $payroll = \DB::select("SELECT YEAR(schedule.date) AS 'year', MONTH(schedule.date) AS 'month', COUNT(schedule.date) * (salary / 173) AS 'pay' FROM employee INNER JOIN schedule ON schedule.employee_id = employee.employee_id WHERE schedule.date NOT IN (SELECT absence.date FROM absence NATURAL JOIN absence_type WHERE name LIKE '%unpaid%' AND employee_id = ? ) AND schedule.date < NOW() AND employee.employee_id = ? GROUP BY YEAR(schedule.date) , MONTH(schedule.date), salary", [$request->session()->get('employee_id'), $request->session()->get('employee_id')]);

        return response()->json($payroll, 200);
    }
}
