<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Helper\Security;
use App\Models\Employee;
use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\AddemployeeRequest;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function getAll(EmployeeRequest $request)
    {
        $data = $request->only(['x']);

        if (Security::sessionCheck($data['x']) == false) {
            return response()->json([
                'success' => false,
                'message' => 'Token is invalid'
            ]);
        }

        $data = Employee::all();

        // return response()->json($data);
        return response()->json([
            'success' => true,
            'message' => 'Successfully retrieved',
            'data' => $data
        ]);
    }

    public function createEmployee(AddemployeeRequest $request)
    {
        $data = $request->only(['x', 'xnip', 'xname', 'xemail', 'xphone_number', 'xaddress']);

        if (Security::sessionCheck($data['x']) == false) {
            return response()->json([
                'success' => false,
                'message' => 'Token is invalid'
            ]);
        }

        $dataset = [
            'nip' => $data['xnip'],
            'name' => $data['xname'],
            'email' => $data['xemail'],
            'phone_number' => $data['xphone_number'],
            'address' => $data['xaddress'],
        ];

        Employee::create($dataset);

        return response()->json([
            'success' => true,
            'message' => 'Successfully add new employee'
        ]);
    }

    public function checkEmployee(Request $request)
    {
        $data = $request->only(['xnip']);

        $item = Employee::where('nip', $data['xnip'])->first();

        if (empty($item)) {
            return response()->json(true);
        }

        return response()->json(false);
    }
}