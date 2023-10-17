<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventAPIController extends Controller
{
    public function detailEvent(string $id)
    {
        $event = DB::table("event")
        ->join("users","event.created_by_user_id","=","users.id")
        ->select("event.id","event.title","event.description",
                "event.date","event.time","event.location","event.slots_available",
                "users.name as created_by")
        ->where("event.id","=",$id)->first();

        if(!$event){
            return response()->json([
                "message" => "Event is not found",
                "status" => 404
            ],404);
        }

        return response()->json([
            "message" => "OK",
            "status" => 200,
            "data" => [
                "event" => $event
            ]
        ],200);
    }
    public function allEvent(Request $request)
    {
        $page = $request->input("page") ?? 1;

        $events = DB::table("event")
            ->leftJoin("booking","event.id","=","booking.event_id")
            ->leftJoin("users","event.created_by_user_id","=","users.id")
            ->select("event.id","event.title","event.description",
                "event.date","event.time","event.location","event.slots_available",
                DB::raw("count(booking.id) as total_booking"), "users.id as id_user")
            ->groupBy("event.id")
            ->paginate(perPage:10,page:$page);

        if(!$events){
            return response()->json([
                "message" => "Cannot, retrieving data.",
                "status" => 401
            ],401);
        }

        return response()->json([
            "message" => "OK",
            "status" => 200,
            "data" => [
                "events" => $events
            ]
        ],200);
    }
}
