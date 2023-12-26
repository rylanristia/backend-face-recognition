<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Http\Helper\Security;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        if (Security::sessionCheck($request->x) == false) {
            return response()->json([
                'success' => false,
                'message' => 'Token is invalid'
            ]);
        }

        $year = $request->xyear;
        $month = $request->xmonth;

        $dates = [];
        $result = [];

        for ($i = 1; $i <= $this->monthLenght($year, $month); ++$i) {
            $dates[] = Carbon::createFromDate((int)$year, (int)$month, $i)->format('Y-m-d');
        }

        $data = Attendance::where('nip', $request->xnip)->get();

        $dataAttendance = [];

        foreach ($data as $item) {
            $dataAttendance[] = [
                'date' => strftime("%Y-%m-%d", strtotime($item->checked_in)),
                'in' => strftime("%H:%M", strtotime($item->checked_in)),
                'out' => (!empty($item->checked_out)) ? strftime("%H:%M", strtotime($item->checked_out)) : "--:--"
            ];
        }

        for ($i = 0; $i < sizeof($dates); $i++) {
            $result[] = [
                'date' => $dates[$i],
                'status' => 'Absence',
                'time' => [
                    'checked_in'    => "--:--",
                    'checked_out'   => "--:--",
                ]
            ];
        }

        for ($i = 0; $i < sizeof($result); $i++) {
            for ($j = 0; $j < sizeof($dataAttendance); $j++) {
                if ($result[$i]['date'] == $dataAttendance[$j]['date']) {
                    $result[$i] = [
                        'date' => $dates[$i],
                        'status' => 'Attend',
                        'time' => [
                            'checked_in'    => $dataAttendance[$j]['in'],
                            'checked_out'   => $dataAttendance[$j]['out'],
                        ]
                    ];
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Successfully retrieved',
            'data' => $result
        ]);
    }

    public function monthLenght($year, $month)
    {
        $lenght = 0;

        switch ($month) {
            case 1:
                $lenght = 31;
                break;

            case 2:
                ($year % 4 == 0) ? $lenght = 29 : $lenght = 28;
                break;

            case 3:
                $lenght = 31;
                break;

            case 4:
                $lenght = 30;
                break;

            case 5:
                $lenght = 31;
                break;

            case 6:
                $lenght = 30;
                break;

            case 7:
                $lenght = 31;
                break;

            case 8:
                $lenght = 31;
                break;

            case 9:
                $lenght = 30;
                break;

            case 10:
                $lenght = 31;
                break;

            case 11:
                $lenght = 30;
                break;

            case 12:
                $lenght = 31;
                break;

            default:
                $lenght = 0;
                break;
        }

        return $lenght;
    }
}