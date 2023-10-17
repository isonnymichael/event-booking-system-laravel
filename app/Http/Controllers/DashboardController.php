<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard():Response
    {
        $breadcrumbs = [
            [
                "title" => "Dashboard",
                "link" => ""
            ]
        ];

        $datas = [];

        if(Auth::user()->role == "admin"){
            $events = DB::table("event")->count('id');
            $bookeds = DB::table("booking")->count('id');
            $users = DB::table("users")->count('id');
            $latest_event = DB::table("event")
            ->leftJoin("booking","event.id","=","booking.event_id")
            ->select("event.id","event.title","event.description",
                "event.date","event.time","event.location","event.slots_available",
                DB::raw("count(booking.id) as total_booking"))
            ->orderBy("event.date","desc")
            ->orderBy("event.time","desc")
            ->groupBy("event.id")->limit(5)
            ->get();

            $recenly_added_event = DB::table("event")
            ->leftJoin("booking","event.id","=","booking.event_id")
            ->leftJoin("users","event.created_by_user_id","=","users.id")
            ->select("event.id","event.title","event.description",
                "event.date","event.time","event.location","event.slots_available",
                DB::raw("count(booking.id) as total_booking"),"users.name")
            ->orderBy("event.created_at","desc")
            ->groupBy("event.id")->limit(5)
            ->get();

            $datas = [
                "card" => [
                    "events" => number_format($events,0,",","."),
                    "bookeds" => number_format($bookeds,0,",","."),
                    "users" => number_format($users,0,",",".")
                ],
                "latest_event" => $latest_event,
                "recenly_added_event" => $recenly_added_event
            ];
        }else{
            $contribute_events = DB::table("event")->where("created_by_user_id")->count('id');
            $my_events = DB::table("booking")->where("user_id","=",Auth::user()->id)->count('id');
            $events = DB::table("event")->count('id');
            $latest_event = DB::table("event")
            ->leftJoin("booking","event.id","=","booking.event_id")
            ->select("event.id","event.title","event.description",
                "event.date","event.time","event.location","event.slots_available",
                DB::raw("count(booking.id) as total_booking"))
            ->orderBy("event.date","desc")
            ->orderBy("event.time","desc")
            ->groupBy("event.id")->limit(5)
            ->get();

            $recenly_added_event = DB::table("event")
            ->leftJoin("booking","event.id","=","booking.event_id")
            ->leftJoin("users","event.created_by_user_id","=","users.id")
            ->select("event.id","event.title","event.description",
                "event.date","event.time","event.location","event.slots_available",
                DB::raw("count(booking.id) as total_booking"),"users.name")
            ->where("booking.user_id","=",Auth::user()->id)
            ->where("event.date",">", date("Y-m-d"))
            ->orderBy("event.created_at","desc")
            ->groupBy("event.id")->limit(5)
            ->get();

            $datas = [
                "card" => [
                    "contribute_events" => number_format($contribute_events,0,",","."),
                    "my_events" => number_format($my_events,0,",","."),
                    "events" => number_format($events,0,",",".")
                ],
                "latest_event" => $latest_event,
                "recenly_added_event" => $recenly_added_event
            ];
        }

        return response()
            ->view("dashboard.dashboard",[
                "title" => "Dashboard",
                "breadcrumbs" => $breadcrumbs,
                "datas" => $datas
            ]);
    }
}
