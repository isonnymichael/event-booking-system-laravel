<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class EventController extends Controller
{
    public function detailEvent(string $id)
    {
        $event = DB::table("event")
        ->join("users","event.created_by_user_id","=","users.id")
        ->where("event.id","=",$id)->first();

        if(!$event){
            Session::flash('error', 'Event not found');
            return back();
        }

        $isBooked = false;
        if(Auth::user()->role == "user" && $event->created_by_user_id != Auth::user()->id){
            $isBooked = DB::table("booking")
                ->where([
                    "user_id" => Auth::user()->id,
                    "event_id" => $id,
            ])->count("id") > 0;
        }

        $isFull = false;

        $total_booked = DB::table("booking")->where("event_id","=",$id)->count("id");
        $total_slot = DB::table("event")->where("id","=",$id)->select("slots_available")->first()->slots_available;

        if($total_booked >= $total_slot){
           $isFull = true;
        }

        $breadcrumbs = [
            [
                "title" => "Dashboard",
                "link" => "/dashboard"
            ],
            [
                "title" => "All Event",
                "link" => "/event/list"
            ],
            [
                "title" => $event->title,
                "link" => ""
            ]
        ];

        return response()
            ->view("dashboard.event-detail",[
                "title" => $event->title,
                "breadcrumbs" => $breadcrumbs,
                "event" => $event,
                "idEvent" => $id,
                "isBooked" => $isBooked,
                "isFull" => $isFull
            ]);
    }
    public function allEvent()
    {
        $breadcrumbs = [
            [
                "title" => "Dashboard",
                "link" => "/dashboard"
            ],
            [
                "title" => "All Event",
                "link" => ""
            ]
        ];

        $events = DB::table("event")
            ->leftJoin("booking","event.id","=","booking.event_id")
            ->leftJoin("users","event.created_by_user_id","=","users.id")
            ->select("event.id","event.title","event.description",
                "event.date","event.time","event.location","event.slots_available",
                DB::raw("count(booking.id) as total_booking"), "users.id as id_user")
            ->groupBy("event.id")
            ->get();

        return response()
            ->view("dashboard.events",[
                "title" => "All Event",
                "breadcrumbs" => $breadcrumbs,
                "events" => $events
            ]);
    }
    public function myEvent()
    {
        $breadcrumbs = [
            [
                "title" => "Dashboard",
                "link" => "/dashboard"
            ],
            [
                "title" => "My Event",
                "link" => ""
            ]
        ];

        $events = DB::table("event")
            ->leftJoin("booking","event.id","=","booking.event_id")
            ->leftJoin("users","event.created_by_user_id","=","users.id")
            ->select("event.id","event.title","event.description",
                "event.date","event.time","event.location","event.slots_available",
                DB::raw("count(booking.id) as total_booking"), "users.id as id_user")
            ->where("booking.user_id","=",Auth::user()->id)
            ->groupBy("event.id")
            ->get();

        return response()
            ->view("dashboard.event-my",[
                "title" => "My event",
                "breadcrumbs" => $breadcrumbs,
                "events" => $events
            ]);
    }
    public function contributeEvent()
    {
        $breadcrumbs = [
            [
                "title" => "Dashboard",
                "link" => "/dashboard"
            ],
            [
                "title" => "Contribue Event",
                "link" => ""
            ]
        ];

        $events = DB::table("event")->where("created_by_user_id","=",Auth::user()->id)->get();

        return response()
            ->view("dashboard.event-contribute",[
                "title" => "Contribute Event",
                "breadcrumbs" => $breadcrumbs,
                "events" => $events
            ]);
    }
    public function bookedEvent()
    {
        $breadcrumbs = [
            [
                "title" => "Dashboard",
                "link" => "/dashboard"
            ],
            [
                "title" => "Booked Event",
                "link" => ""
            ]
        ];

        $bookeds = DB::table("booking")
            ->leftJoin("event","booking.event_id","=","event.id")
            ->leftJoin("users","booking.user_id","=","users.id")
            ->select("event.id","event.title","event.description",
                "event.date","event.time","event.location",
                "users.name","booking.booked_at")
            ->get();

        return response()
            ->view("dashboard.event-booked",[
                "title" => "Booked Event",
                "breadcrumbs" => $breadcrumbs,
                "bookeds" => $bookeds
            ]);
    }
    public function addEvent(Request $request)
    {
        $datas = request()->except(['_token','files']);
        $datas['created_by_user_id'] = Auth::user()->id; 
        $datas['created_at'] = Carbon::now();
        $datas['updated_at'] = Carbon::now();
        $result = DB::table("event")->insert($datas);

        if(!$result){
            Session::flash('error', 'Failed add new event');
        }

        Session::flash('status', 'Success add new event');
        return back();
    }
    public function editEvent(Request $request)
    {
        $datas = request()->except(['_token','id','files']);
        $datas['updated_at'] = Carbon::now();

        $result = DB::table("event")->where("id","=",$request->input("id"))
            ->update($datas);
        
        if(!$result){
            Session::flash('error', 'Failed edit event '.$request->input("title"));
        }

        Session::flash('status', 'Success edit event '.$request->input("title"));
        return back();
    }
    public function deleteEvent(Request $request)
    {
        $result = DB::table("event")->where("id","=",$request->input("id"))->delete();
        
        if(!$result){
            Session::flash('error', 'Failed delete event '.$request->input("title"));
        }

        Session::flash('status', 'Success delete event '.$request->input("title"));
        return back();
    }
    public function bookingEvent(Request $request)
    {
        $datas = request()->except(['_token']);
        $datas['user_id'] = Auth::user()->id; 
        $datas['booked_at'] = Carbon::now();

        $isBooked = DB::table("booking")
        ->where([
                "user_id" => Auth::user()->id,
                "event_id" => $request->input("event_id"),
        ])->count("id") > 0;
        
        if($isBooked){
            Session::flash('error', 'You have registered for this event');
            return back();
        }

        $total_booked = DB::table("booking")->where("event_id","=",$request->input("event_id"))->count("id");
        $total_slot = DB::table("event")->where("id","=",$request->input("event_id"))->select("slots_available")->first()->slots_available;

        if($total_booked >= $total_slot){
            Session::flash('error', 'Sorry, slot is full.');
            return back();
        }

        $result = DB::table("booking")->insert($datas);

        if(!$result){
            Session::flash('error', 'Failed booking event');
            return back();
        }

        Session::flash('status', 'Success booking event');
        return back();
    }
}
