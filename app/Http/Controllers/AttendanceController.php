<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceRequest;
use App\Http\Resources\AttendanceResource;
use App\Models\Attendance;
use App\Services\AttendanceService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    use ResponseTrait;
    protected $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }
    public function __invoke(AttendanceRequest $request)
    {
        try {
            if ($request->clock_type == 'check_in') {
                $attendance = $this->attendanceService->checkIn($request);
            } else {
                $attendance = $this->attendanceService->checkOut($request);
            }
            return $this->sendSuccess(new AttendanceResource($attendance),'Success Attendance',200);
        
        } catch (\Exception $exception) {
            return $this->sendError([], $exception->getMessage(), 422);
        }
    }

}
