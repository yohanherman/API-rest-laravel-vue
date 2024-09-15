<?php

namespace App\Http\Controllers\V1;

use App\Models\booking;
use App\Models\places;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class bookingController
{
    public function index()
    {
        $datas = DB::table('bookings')
            ->join('users', 'users.id', '=', 'bookings.user_id')
            ->join('places', 'places.id', '=', 'bookings.place_id')
            ->get();

        if ($datas) {
            $response = [
                'datas' => $datas,
                'success' => true,
                'status' => 200
            ];
            return response()->json($response, 200);
        }
        $response = [
            'datas' => $datas,
            'success' => false,
            'status' => 500
        ];
        return response()->json($response, 500);
    }


    public function book(Request $request)
    {
        $rules = [
            'user_id' => 'required',
            'place_id' => 'required',
            'booking_date' => 'required|date'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => 'validation error.',
                $validator->errors(),
                'status' => 400
            ];
            return response()->json($response, 500);
        }

        $datas = booking::create($request->all());

        $placestatus = places::where('id', $request->input('place_id'))->first();
        $placestatus->status_id = 2;
        $placestatus->save();

        if (isset($datas)) {
            $response = [
                'datas' => $datas,
                'success' => true,
                'status' => 201,
                'message' => 'successfuly created , and status updated'
            ];
            return response()->json($response, 201);
        }
        $response = [
            'datas' => $datas,
            'success' => false,
            "status" => 500
        ];
        return response()->json($response, 500);
    }
}
