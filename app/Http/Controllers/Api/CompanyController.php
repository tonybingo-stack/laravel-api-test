<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Company;

class CompanyController extends Controller
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

            $total_count = Company::count();

            $companies = Company::offset(($page_no - 1) * $limit)
                ->orderBy("id", "desc")->take($limit)->get();

            foreach($companies as $item) {
                $item["logo"] = env('APP_URL').'/uploads/'.$item["logo"];
            }

            $response["data"] = $companies;
            $response["total"] = $total_count;
            $response['message'] = 'Companies fetched successfully';
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
                'name' => 'required|string',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());
                return response()->json($errorResponse, $response['status']);
            }

            $request_data = $request->all();

            $name = $request_data["name"];
            $email = $request_data["email"] ?? "";
            $website = $request_data["website"];            

            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $fileName = time() . '-' . $file->getClientOriginalName();
                $file->move(IMAGE_UPLOAD_PATH, $fileName);
                $logo = $fileName;
            } else {
                $logo = trim($request_data["logo"], env('APP_URL').'/uploads/company/');
            }

            $company = new Company;

            $company->name = $name;
            $company->email = $email;
            $company->logo = $logo;
            $company->website = $website;

            if ($company->save()) {

                $email = $company->email;

                $mailData  = [
                    'title' => $company->name,
                ];

                \Mail::to($email)->send(new \App\Mail\TestMail($mailData ));

            }

            $response['message'] = 'Company Data saved successfully';
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
                'name' => 'required|string',
            ];

            $request_data = $request->all();

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());
                return response()->json($errorResponse, $response['status']);
            }

            $name = $request_data["name"];
            $email = $request_data["email"] ?? "";
            $website = $request_data["website"];            

            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $fileName = time() . '-' . $file->getClientOriginalName();
                $file->move(IMAGE_UPLOAD_PATH, $fileName);
                $logo = $fileName;
            } else {
                $logo = trim($request_data["logo"], env('APP_URL').'/uploads/company/');
            }

            $company = Company::find($id);

            $company->name = $name;
            $company->email = $email;
            $company->logo = $logo;
            $company->website = $website;

            $company->save();

            $response['message'] = 'Company Data updated successfully';
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

            $company = Company::where("id", $id)->delete();

            $response['message'] = 'Company Data deleted successfully';
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
