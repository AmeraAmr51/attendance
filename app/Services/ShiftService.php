<?php

namespace App\Services;

use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class ShiftService
{

    public function getAvailableShift($id):Model
    {
        //1. check if shift available or not 
        $currentTime = now();
        $shift = Shift::whereId($id)
            ->whereBetween($currentTime, ['start_shift', 'end_shift'])
            ->first();
        if (!$shift)
            throw new \Exception('There is no shift Available now');
        
        return $shift;

    }
}