<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceRequest;
use App\Models\Attendance;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{

    public $flag = '16:00';

    public function attendance(AttendanceRequest $request)
    {
        $data = $request->nip;

        $result = [];

        if (sizeof($data) > 0) {
            for ($i = 0; $i < sizeof($data); $i++) {

                if ($data[$i] != 'unknown') {

                    $check = $this->checkAttendance($data[$i]);

                    $result[$i] = $check;
                } else {
                    $result[$i] = 'unknown';
                }
            }
        }

        return response()->json($result);
    }

    public function checkAttendance($nip)
    {
        $data = Attendance::where('nip', $nip)->orderBy('checked_in', 'desc')->select('nip', 'checked_in', 'checked_out')->first();

        if (!empty($data)) {

            $date       = date('Y-m-d', strtotime($data->checked_in));
            $date_now   = date('Y-m-d');

            if ($date == $date_now) {

                $hour_flag  = date('H:i', strtotime($this->flag));
                $hour_now   = date('H:i');

                if ($hour_now >= $hour_flag) {
                    $result = $this->checkedoutAttendance($nip);
                } else {
                    $result = $nip . " sudah presensi datang";
                }
            } else {
                $result = $this->checkedinAttendance($nip);
            }
        } else {
            $result = $this->checkedinAttendance($nip);
        }

        return $result;
    }

    public function checkedinAttendance($nip)
    {
        Attendance::create([
            'nip' => $nip,
            'checked_in' => Date('Y-m-d H:i:s')
        ]);

        $result = $nip . " presensi datang.";

        return $result;
    }

    public function checkedoutAttendance($nip)
    {
        $date_now = Date('Y-m-d H:i:s');

        $query      = "update attendance set checked_out = :date where nip = :nip and DATE_FORMAT(checked_in, '%Y-%m-%d') = DATE_FORMAT(NOW(), '%Y-%m-%d')";
        $exec       = DB::connection('mysql')->update($query, [
            'nip' => $nip,
            'date' => $date_now
        ]);

        if ($exec > 0) {
            return $nip . " presensi pulang";
        }
    }
}