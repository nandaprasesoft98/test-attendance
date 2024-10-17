<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class AttendanceApiController extends BaseApiController
{
    public function getAttendanceList(Request $request)
    {
        $attendances = Attendance::all();
        if (count($attendances) == 0) {
            return $this->sendError("Attendance is empty.");
        }
        return $this->sendResponse($attendances, "Success");
    }

    public function postAttendance(Request $request)
    {
        $selectedAttendancesBasedUser = Attendance::where('user_id', 1)->firstOrFail();
        return $this->sendResponse($selectedAttendancesBasedUser, "Success");
    }
}
