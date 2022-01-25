<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use DateTime;

class GetCurrency extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get_currency';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get currency';

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

        #смотрим свужую дату в базе
        $cur_rate = DB::table('currency_rate')
            ->latest('date')
            ->first();

        # если данных в базе нету, то дата на 15 дней раньше
        if ($cur_rate) {
            $date = new DateTime($cur_rate->date);
            $date = $date->modify('1 day');
        }
        else {
            $date = new DateTime();
            $date = $date->modify('-15 day');
        }

        # проверяем пустая или нет таблица валют
        $cur = DB::table('currency')->count();
        $load_currency = ($cur == 0) ? True : False;

        $url = "https://www.nbrb.by/api/exrates/rates?periodicity=0&ondate=";

        # сегодняшняя дата
        $today = new DateTime();

        while ($date <= $today) {
            # дата курса
            print "загружаем курсы на дату: " . $date->format('Y-m-d') . "\n";

            # загружаем курс на дату
            $response = Http::get($url . $date->format('Y-m-d'));
            foreach ($response->json() as $item) {

                # если валют нет, то загружаем в таблицу
                if ($load_currency) {
                    DB::table('currency')->insert([
                        'name' => $item["Cur_Name"],
                        'charcode' => $item["Cur_Abbreviation"],
                        'numcode' => intval($item["Cur_ID"]),
                        'scale' => intval($item["Cur_Scale"])
                    ]);
                };

                # заполняем таблицу курсами
                DB::table('currency_rate')->insert([
                        'date' => $item["Date"],
                        'numcode' => intval($item["Cur_ID"]),
                        'rate' => $item["Cur_OfficialRate"]
                ]);
            }

            $load_currency = False;
            $date = $date->modify('1 day');
        }

        return 0;
    }
}
