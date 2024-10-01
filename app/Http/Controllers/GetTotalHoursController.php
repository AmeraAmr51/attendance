<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceRequest;
use App\Http\Requests\GetTotalHoursRequest;
use App\Models\Attendance;
use App\Services\AttendanceService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class GetTotalHoursController extends Controller
{
    use ResponseTrait;
    protected $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }
    public function __invoke(GetTotalHoursRequest $request)
    {
        try {
            $totalHours=$this->calculateTotalHours($request);
            return $this->sendSuccess($totalHours,'Your Total Hours',200);
        
        } catch (\Exception $exception) {
            return $this->sendError([], $exception->getMessage(), 422);
        }
    }

}
