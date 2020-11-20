<?php

namespace App\Http\Controllers;

use App\Model\Sql\Employee as EmployeeModel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class Employee extends BaseController
{
    /**
     * Get Employee list
     *
     * @param Request $request
     * @return Array
     */
    public function getList(Request $request)
    {

        $page = intval($request->page - 1) * $request->size;
        $size = intval($request->size);
        $keyword = trim($request->keyword);

        $offset = $page;

        try {

            $details = EmployeeModel::SELECT('id', 'name', 'address', 'contact')
                ->Where('name', 'like', '%' . $keyword . '%')
                ->orWhere('address', 'like', '%' . $keyword . '%')
                ->orWhere('contact', 'like', '%' . $keyword . '%')
                ->skip($offset)
                ->take($size)
                ->orderby('id')
                ->get();

            $total = EmployeeModel::Where('name', 'like', '%' . $keyword . '%')
                ->orWhere('address', 'like', '%' . $keyword . '%')
                ->orWhere('contact', 'like', '%' . $keyword . '%')
                ->count();

            $data = [];
            $data['records'] = $details->toArray();
            $data['total'] = $total;
            $response = [
                'code'  =>  200,
                'message'   =>  'success',
                'data' => $data
            ];

            return response($response);
        } catch (\Throwable $e) {

            $response = [
                'code'  =>  400,
                'message'   =>  $e->getMessage() ?? 'something went wrong please try again!',
                'data'  =>  []
            ];

            return response($response);
        }
    }

    /**
     * Get Employee Detail
     *
     * @param Request $request
     * @return Array
     */
    public function getEmployee(Request $request)
    {

        $messages = [
            'required' => 'Employee id required',
        ];

        $rule = [
            'id' => 'required'
        ];

        $validator = Validator::make($request->all(), $rule, $messages);

        if ($validator->fails()) {
            $errors = $validator->errors();

            foreach ($errors->all() as $error) {
                $errorResponse = [
                    'code' => 601,
                    'status' => 'failed',
                    'message' => $error
                ];
                return $errorResponse;
            }
        }

        $employeeId = intval($request->id);

        try {
            $details = EmployeeModel::SELECT('id', 'name', 'address', 'contact')
                ->where('id', $employeeId)
                ->first();

            $data = [];
            if ($details !== null) {

                $response = [
                    'code'  =>  200,
                    'message'   =>  'success',
                    'data' => $details->toArray()
                ];
            } else {

                $response = [
                    'code'  =>  400,
                    'message'   =>  'No data found',
                    'data' => []
                ];
            }

            return response($response);
        } catch (\Throwable $e) {

            $response = [
                'code'  =>  400,
                'message'   =>  $e->getMessage() ?? 'something went wrong please try again!',
                'data'  =>  []
            ];

            return response($response);
        }
    }

    /**
     * Edit Employee Detail
     *
     * @param Request $request
     * @return Array
     */
    public function editEmployee(Request $request)
    {

        $messages = [
            'required' => 'Employee id required',
        ];

        $rule = [
            'id' => 'required',
            'name' => 'required',
            'address' => 'required',
            'contact' => 'required'
        ];

        $validator = Validator::make($request->all(), $rule, $messages);

        if ($validator->fails()) {
            $errors = $validator->errors();

            foreach ($errors->all() as $error) {
                $errorResponse = [
                    'code' => 601,
                    'status' => 'failed',
                    'message' => $error
                ];
                return $errorResponse;
            }
        }

        $employeeId = intval($request->id);

        try {
            $details = EmployeeModel::where('id', intval($request->id))
                ->update([
                    'name'  =>  trim($request->name),
                    'address'  =>  trim($request->address),
                    'contact'  =>  trim($request->contact),
                ]);

            if ($details) {

                $response = [
                    'code'  =>  200,
                    'message'   =>  'success',
                    'data' => []
                ];
            } else {

                $response = [
                    'code'  =>  400,
                    'message'   =>  'something went wrong please try again!',
                    'data' => []
                ];
            }

            return response($response);
        } catch (\Throwable $e) {

            $response = [
                'code'  =>  400,
                'message'   =>  $e->getMessage() ?? 'something went wrong please try again!',
                'data'  =>  []
            ];

            return response($response);
        }
    }

    /**
     * Delete Employee Detail
     *
     * @param Request $request
     * @return Array
     */
    public function deleteEmployee(Request $request)
    {

        $messages = [
            'required' => 'Employee id required',
        ];

        $rule = [
            'id' => 'required'
        ];

        $validator = Validator::make($request->all(), $rule, $messages);

        if ($validator->fails()) {
            $errors = $validator->errors();

            foreach ($errors->all() as $error) {
                $errorResponse = [
                    'code' => 601,
                    'status' => 'failed',
                    'message' => $error
                ];
                return $errorResponse;
            }
        }

        $employeeId = intval($request->id);

        try {
            $details = EmployeeModel::where('id', intval($request->id))
                ->delete();

            if ($details) {

                $response = [
                    'code'  =>  200,
                    'message'   =>  'success',
                    'data' => []
                ];
            } else {

                $response = [
                    'code'  =>  400,
                    'message'   =>  'something went wrong please try again!',
                    'data' => []
                ];
            }

            return response($response);
            
        } catch (\Throwable $e) {

            $response = [
                'code'  =>  400,
                'message'   =>  $e->getMessage() ?? 'something went wrong please try again!',
                'data'  =>  []
            ];

            return response($response);
        }
    }
}
