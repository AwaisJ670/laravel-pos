<?php

namespace App\Console\Commands;

use App\Models\AttendanceLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckoutUpdateCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkoutUpdate:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checkout All Users at 8:00 pm';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $todayCheckIns = AttendanceLog::whereDate('check_date_time', '=', getCurrentServerDate())
            ->where('in_out_mode', 0)
            ->get();
        foreach($todayCheckIns as $checkIn){
            $attendanceLog = new AttendanceLog();
            $attendanceLog->enroll_number = $checkIn->enroll_number;
            $attendanceLog->in_out_mode = 1;
            $attendanceLog->check_date_time = getCurrentServerDateTime();
            $attendanceLog->save();
        }

       Log::info("Checkout Successfully !");
    }
}
