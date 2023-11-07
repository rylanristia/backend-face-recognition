<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceRequest;
use App\Models\Attendance;
use Exception;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function attendance(AttendanceRequest $request)
    {
        $data = $request->nip;

        $result = '';
        if (sizeof($data) > 0) {
            for ($i = 0; $i < sizeof($data); $i++) {

                $item = Attendance::where('nip', $data[$i])->orderBy('checked_in', 'desc')->first();

                $result = $data[$i] . " Sudah melakukan presensi hari ini";

                if ($data[$i] != 'unknown') {

                    if (isset($item['nip'])) {

                        $date       = date('Y-m-d', strtotime($item->checked_in));
                        $date_now   = date('Y-m-d');

                        if ($date != $date_now) {
                            try {
                                Attendance::create([
                                    'nip' => $data[$i],
                                    'checked_in' => Date('Y-m-d H:i:s')
                                ]);

                                $result = $data[$i] . " Berhasil melakukan presensi!";
                            } catch (Exception $e) {
                                $result = $e;
                            }
                        } else {
                            $result = 'Nip ' . $data[$i] . ' sudah melakukan presensi hari ini!';
                            continue;
                        }
                    } else {
                        try {
                            Attendance::create([
                                'nip' => $data[$i],
                                'checked_in' => Date('Y-m-d H:i:s')
                            ]);

                            $result = $data[$i] . " Berhasil melakukan presensi!";
                        } catch (Exception $e) {
                            $result = $e;
                        }
                    }
                } else {
                    $result = 'Unknown';
                    continue;
                }
            }
        } else {
            $result = 'Unknown';
        }

        return response()->json($result);
    }
}