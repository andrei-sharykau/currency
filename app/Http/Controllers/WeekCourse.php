<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use DateTime;

class WeekCourse extends Controller
{
    public function show()
    {   
        $old_date = new DateTime('-6 days');
        $today = new DateTime();

        $message = "Курсы валют с: " . $old_date->format('d-m-Y') . " по: " . $today->format('d-m-Y');

        $date_period=array();
        while ($old_date <= $today) {
            array_push($date_period, $old_date->format('d-m-Y'));
            $old_date = $old_date->modify( '1 day' );
        }


        $all_currency = DB::table('currency')
            ->select('numcode', 'charcode', 'name', 'scale')
            ->get();

        $all_currency_rate = DB::table('currency_rate')
            ->select('numcode', 'rate', 'date')
            ->oldest('date')
            ->whereDate('currency_rate.date', '>=', $today->modify('-6 day'))
            ->get();


        $all_currency_all_rates=array();
        $rates = array();
        $my_cur = array();
        foreach ($all_currency as $cur) {
            foreach ($all_currency_rate as $rate) {
                if ($cur->numcode == $rate->numcode) {
                    array_push($rates, $rate->rate);
                }
            }
            
            $my_cur = [
                'numcode'  => $cur->numcode,
                'charcode' => $cur->charcode,
                'name'     => $cur->name,
                'scale'    => $cur->scale,
                'rates'    => $rates];
            
            array_push($all_currency_all_rates, $my_cur);   
            $my_cur =array();
            $rates = array();
        }


        return view('welcome', [
            'message' => $message, 
            'date_period' => $date_period,
            'all_currency_all_rates' => $all_currency_all_rates,
        ]);
    }
}
