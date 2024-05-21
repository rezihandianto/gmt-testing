<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('employee.index');
    }
    public function getData(Request $request)
    {
        $keyword   = $request['searchkey'];

        $employees = Employee::select()
            ->offset($request['start'])
            ->limit(($request['length'] == -1) ? Employee::where('is_deleted', false)->count() : $request['length'])
            ->when($keyword, function ($query, $keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->get();

        $employeesCounter = Employee::select()
            ->when($keyword, function ($query, $keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->count();
        $response = [
            'status'          => true,
            'draw'            => $request['draw'],
            'recordsTotal'    => Employee::count(),
            'recordsFiltered' => $employeesCounter,
            'data'            => $employees,
        ];
        return $response;
    }
    public function store(Request $request)
    {
        $fileName = \Str::random(20);
        $path = 'images/employee/';
        try {
            DB::beginTransaction();
            $data = ['status' => false, 'code' => 400, 'message' => 'Data failed to create'];
            $validator = Validator::make(
                $request->all(),
                [
                    'name'              => 'required',
                    'birth_date'        => 'required|date',
                    'address'           => 'required',
                    'marital_status'    => 'required',
                    'photo'             => 'required|image|max:10240',
                ]
            );
            if ($validator->fails()) {
                return response()->json(['status' => false, 'code' => 403, 'message' => $validator->errors()]);
            }
            if ($request->file('photo') != null) {
                $extension = $request->file('photo')->extension();
                $photoName = $fileName . '.' . $extension;
                Storage::disk('public')->putFileAs($path, $request->file('photo'), $fileName . "." . $extension);
            } else {
                $photoName = null;
            }
            $employee = new Employee();
            $employee->name = $request->name;
            $employee->birth_date = $request->birth_date;
            $employee->address = $request->address;
            $employee->marital_status = $request->marital_status;
            $employee->photo = $photoName;
            $employee->save();

            if ($employee) {
                DB::commit();
                $data = ['status' => true, 'code' => 201, 'message' => 'Data successfully created'];
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            $data = ['status' => false, 'code' => 500, 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function show($id)
    {
        try {
            $data = ['status' => false, 'message' => 'Data failed to be found'];
            $employee = Employee::where('id', $id)->first();
            if ($employee) {
                $data = ['status' => true, 'message' => 'Data was successfully found', 'data' => $employee];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function update(Request $request)
    {
        $fileName = \Str::random(20);
        $path = 'images/employee/';
        $employee = Employee::find($request->id);
        try {
            DB::beginTransaction();
            $data = ['status' => false, 'code' => 400, 'message' => 'Data failed to update'];
            $validator = Validator::make(
                $request->all(),
                [
                    'name'              => 'required',
                    'birth_date'        => 'required|date',
                    'address'           => 'required',
                    'marital_status'    => 'required',
                    'photo'             => 'image|max:10240',
                ]
            );
            if ($validator->fails()) {
                return response()->json(['status' => false, 'code' => 403, 'message' => $validator->errors()]);
            }
            if ($request->file('photo') != null) {
                $extension = $request->file('photo')->extension();
                $photoName = $fileName . '.' . $extension;
                Storage::disk('public')->putFileAs($path, $request->file('photo'), $fileName . "." . $extension);
            } else {
                $photoName = $employee->photo;
            }

            $employee->name = $request->name;
            $employee->birth_date = $request->birth_date;
            $employee->address = $request->address;
            $employee->marital_status = $request->marital_status;
            $employee->photo = $photoName;
            $employee->save();

            if ($employee) {
                DB::commit();
                $data = ['status' => true, 'code' => 201, 'message' => 'Data successfully updated'];
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            $data = ['status' => false, 'code' => 500, 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $data = ['status' => false, 'code' => 400, 'message' => 'Data failed to delete'];
            $employee = Employee::find($id);
            $employee->delete();
            if ($employee) {
                DB::commit();
                $data = ['status' => true, 'code' => 200, 'message' => 'Data deleted successfully'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 500, 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
}
