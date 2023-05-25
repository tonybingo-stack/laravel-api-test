<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Company;
use App\Models\Employee;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;

        try {

            $request_data = $request->all();
            $page_no = $request_data["currentPage"] ?? 1;
            $limit = $request_data["size"] ?? 10;

            $companies = Company::all();

            $company_options = array();

            foreach($companies as $item) {
                array_push($company_options, array("label" => $item["name"], "value" => $item["id"]));
            }

            $total_count = Employee::count();

            $employees = Employee::with('company')->offset(($page_no - 1) * $limit)
                ->orderBy("id", "desc")->take($limit)->get();

            $response["data"] = $employees;
            $response["company_options"] = $company_options;
            $response["total"] = $total_count;
            $response['message'] = 'Employees fetched successfully';
            $response['success'] = TRUE;
            $response['code'] = 0;
            $response['status'] = STATUS_OK;

        } catch (Exception $e) {
            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }

        if ($response['success']) {
            return response()->json($response, STATUS_OK);
        }

        return response()->json($response, STATUS_BAD_REQUEST);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;

        try {

            $rules = [
                'firstName' => 'required|string',
                'lastName' => 'required|string',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());
                return response()->json($errorResponse, $response['status']);
            }

            $request_data = $request->all();

            $first_name = $request_data["firstName"];
            $last_name = $request_data["lastName"];
            $company_id = $request_data["company"];
            $email = $request_data["email"] ?? "";
            $phone = $request_data["phone"] ?? "";

            $employee = new Employee;

            $employee->first_name = $first_name;
            $employee->last_name = $last_name;
            $employee->company_id = $company_id;
            $employee->email = $email;
            $employee->phone = $phone;

            $employee->save();

            $response['message'] = 'Employee Data saved successfully';
            $response['success'] = TRUE;
            $response['code'] = 0;
            $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }

        return response()->json($response, $response['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;

        try {

            $rules = [
                'firstName' => 'required|string',
                'lastName' => 'required|string',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());
                return response()->json($errorResponse, $response['status']);
            }

            $request_data = $request->all();

            $first_name = $request_data["firstName"];
            $last_name = $request_data["lastName"];
            $company_id = $request_data["company"];
            $email = $request_data["email"] ?? "";
            $phone = $request_data["phone"] ?? "";

            $employee = Employee::find($id);

            $employee->first_name = $first_name;
            $employee->last_name = $last_name;
            $employee->company_id = $company_id;
            $employee->email = $email;
            $employee->phone = $phone;

            $employee->save();

            $response['message'] = 'Employee Data updated successfully';
            $response['success'] = TRUE;
            $response['code'] = 0;
            $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }

        return response()->json($response, $response['status']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;

        try {

            $company = Employee::where("id", $id)->delete();

            $response['message'] = 'Employee Data deleted successfully';
            $response['success'] = TRUE;
            $response['code'] = 0;
            $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }

        return response()->json($response, $response['status']);
    }
}
