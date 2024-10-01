<?php

namespace App\Services;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class AttendanceService
{
    protected $shiftService;
    private $model;

    public function __construct(ShiftService $shiftService, Attendance $model)
    {
        $this->shiftService = $shiftService;
        $this->model = $model;
    }
    public function checkIn($data): Model
    {
        // Check the shift based on the current time using ShiftService is Available
        $this->shiftService->getAvailableShift($data->shift_id);

        //Store Check In for Employee
        $attendance = $this->model->create([
            'user_id' => $data->user_id,
            'check_in' => now(),
            'location_type' => $data->location_type,
            'shift_id' => $data->shift_id,
        ]);
        return $attendance;

    }
    public function checkOut($data): Model
    {
        // Check the shift based on the current time using ShiftService is Available
        $this->shiftService->getAvailableShift($data->shift_id);

        // Update Check out and total shift hour for Employee
        $attendance = $this->model->whereUserId($data->user_id)
            ->where("created_at", today())
            ->whereNull("check_out")
            ->latest() // Use latest to get the most recent record
            ->first(); // Get the first record

        $attendance->check_out = now();
        $total_hours = $this->calculatTotalHoursPerShift($attendance->id); // Corrected spelling
        $attendance->total_hours = $total_hours;
        $attendance->save();
        
        return $attendance;

    }

    public function calculatTotalHoursPerShift($id): string
    {
        $userAttendance = $this->model->whereId($id)->first();

        $check_in = Carbon::parse($userAttendance['check_in']);
        $check_out = Carbon::parse($userAttendance['check_out']);
        $total_hours = $check_in->diff($check_out);

        return $total_hours->format("%H:%I:%S");

    }


    public function calculateTotalHours($request)
    {
        // Get the user's attendances for the given month and year
        $total_hours = $this->model
            ->whereUserId($request['user_id'])
            ->where(function ($q) use ($request) {
                if ($request['from'])
                    $q->where('created_at', '>=', $request['from']);
                if ($request['to'])
                    $q->where('created_at', '<=', $request['to']);
            })
            ->selectRaw('SUM(total_hours) as total_hours')
            ->first();


        return $total_hours;
    }


}