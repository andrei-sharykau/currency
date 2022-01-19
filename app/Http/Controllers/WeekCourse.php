<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use DateTime;

class WeekCourse extends Controller
{
    public function show()
    {   
        $start_date = new DateTime('-6 days');
        $end_date = new DateTime();

        $message = "Курсы валют с: " . $start_date->format('Y-m-d') . " по: " . $end_date->format('Y-m-d');

        $date_period=array();
        for ($i = 0; $i <= 6; $i++) {
            array_push($date_period, $end_date->format('Y-m-d'));
            $end_date = $end_date->modify( '-1 day' );
        }



        $all_currency = DB::table('currency')
            ->select('numcode', 'charcode', 'name', 'scale')
            ->get();

        $all_currency_rate = DB::table('currency_rate')
            ->select('numcode', 'rate', 'date')
            ->whereDate('currency_rate.date', '>', $end_date)
            ->get();



        return view('welcome', [
            'message' => $message, 
            'date_period' => $date_period,
            'all_currency' => $all_currency,
            'all_currency_rate' => $all_currency_rate,
        ]);
    }
}
