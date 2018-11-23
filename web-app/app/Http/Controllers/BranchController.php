<?php

namespace App\Http\Controllers;

class BranchController extends Controller
{
    public function getBranches(){
        return response()->json(\DB::select("SELECT * FROM `branch_view`"), 200);
    }

    public function updateBranch(Request $request, $id) {
        $branch = $request->input();
        $branch['id'] = $id;

        $result = \DB::update("UPDATE `branch` SET `branch`.`phone` = :phone, `branch`.`street` = :street `branch`.`apt` = :apt, `branch`.`city` = :city, `branch`.`postal_code` = :postal_code, `branch`.`province` = :province, `branch`.`manager_id` = :manager_id WHERE `branch_id` = :id", $branch);
    
        if (!$result) {
            return response()->json(['message' => 'Error while updating the branc'], 400);
        } else {
            return response()->json(NULL, 200);
        }
    }

    public function addBranch(Request $request) {
        $errors = array();
        $branch = array();
        $branch_address = array();
        if (!$request->has('opening_date')) {
            $branch['opening_date'] = \date_format(time(), "Y-m-d");
        } else {
            $branch['opening_Date'] = $request->input('opening_date');
        }

        if (!$request->has('phone')) {
            $errors[] = ['message' => 'Branch phone number is required'];
        } else {
            $branch['phone'] = $request->input('phone');
        }

        if(!$request->has('street')) {
            $errors[] = ['street' => 'Branch street information is required'];
        } else {
            $branch_address['street'] = $request->input('street');
        }

        if($request->has('apt')) {
            $branch_address['apt'] = $request->input('apt');
        }

        if (!$request->has('city')) {
            $errors[] = ['message' => 'Branch city information is required'];
        } else {
            $branch_address['city'] = $request->input('city');
        }

        if(!$request->has('postal_code')) {
            $errors[] = ['message' => 'Branch postal code is required'];
        } else {
            $branch_address['postal_code'] = $request->input('city');
        }

        if (!$request->has('province')) {
            $errors[] = ['message' => 'Branch province information is required'];
        } else {
            $branch_address['province'] = $request->input('province');
        }

        if(!$errors) {
            return response()->json($errors, 400);
        }
        $result = \DB::insert("INSERT INTO `branch` () VALUES ");
        return response()->json(NULL, 200);
    }
}
