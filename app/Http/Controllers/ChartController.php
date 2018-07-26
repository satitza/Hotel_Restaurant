<?php

namespace App\Http\Controllers;

use DB;
use App\Report;
use App\ActionLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $GLOBALS['controller'] = 'ChartController';
    }

    public function index()
    {
        return view('home', [
            'top5' => $this->TopFiveOfferBooking(),
            //'chart2' => $chart2
        ]);
    }

    public function TopFiveOfferBooking()
    {
        //$offer_name = array();

        //$offers = Report::withCount()



        $top5 = \Chart::title([
            'text' => 'Top 5 Offer Booking',
        ])
            ->chart([
                'type' => 'column', // pie , columnt , line ect
                'renderTo' => 'top5', // render the chart into your div with id
            ])
            ->subtitle([
                //'text' => 'This Subtitle',
            ])
            ->colors([
                '#0c2959'
            ])
            ->xaxis([
                'categories' => [
                    //'Offer 1',
                    //'Offer 2',
                ],
                'labels' => [
                    'rotation' => 15,
                    'align' => 'top',
                    //'formatter' => 'startJs:function(){return this.value + " (Footbal Player)"}:endJs',
                    // use 'startJs:yourjavasscripthere:endJs'
                ],
            ])
            ->yaxis([
                //'text' => 'This Y Axis',
            ])
            ->legend([
                'layout' => 'vertikal',
                'align' => 'right',
                'verticalAlign' => 'middle',
            ])
            ->series(
                [
                    [
                        'name' => 'Max Guest',
                        //'data' => [23, 51],
                        // 'color' => '#0c2959',
                    ],
                ]
            )
            ->display();

        return $top5;

    }


    /**
     * @param $user_id
     * @param $controller
     * @param $function
     * @param $action_id
     */
    public function SaveLog($user_id, $controller, $function, $action_id)
    {
        $action = new ActionLog;
        $action->user_id = $user_id;
        $action->controller = $controller;
        $action->function = $function;
        $action->action_id = $action_id;
        $action->save();
    }
}
