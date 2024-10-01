<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Attendance;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use App\Traits\SendNotificationTrait;

class UserNotification extends Command
{
    use SendNotificationTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:user-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command sends a notification to each user with their total hours for the current month';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        
        // Get the current year and month
        $currentYear = now()->year;
        $currentMonth = now()->month;

        // Query total hours per user, grouping by user_id and summing total_hours
        $usersAttendances = Attendance::select('user_id')
            ->selectRaw('SUM(total_hours) as total_hours')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->groupBy('user_id')
            ->get();

        // Loop through each user and send a notification
        foreach ($usersAttendances as $attendance) {
            // Send notification if there are any hours
            if ($attendance->total_hours > 0) {
                $this->sendNotification($attendance->user_id,'your total hours is '.$attendance->total_hours.'in this mon'.$currentMonth);
            }

        }

        $this->info('Notifications sent to users with their total hours.');
    }
}
