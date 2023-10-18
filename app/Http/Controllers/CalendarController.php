<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalendarController extends Controller
{
    public function calendar()
    {
        $breadcrumbs = [
            [
                "title" => "Dashboard",
                "link" => "/dashboard"
            ],
            [
                "title" => "Calendar",
                "link" => ""
            ]
        ];
        
        $events = DB::table("event")->select(
            "title",
            DB::raw("'false' AS allday"),
            DB::raw("'#0073b7' AS backgroundColor"),
            DB::raw("'#0073b7' AS borderColor"),
            DB::raw("CONCAT('/event/', id) AS url"),
            DB::raw("CONCAT(date, ' ', time) AS start")
            )->get();
    
        return response()
            ->view("dashboard.calendar",[
                "title" => "Calendar",
                "breadcrumbs" => $breadcrumbs,
                "events" => $events
            ]);
    }
}
