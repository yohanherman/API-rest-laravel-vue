<?php

namespace App\Http\Controllers\V1;

use App\Models\booking;
use App\Models\places;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class bookingController
{
    // displaying client booking
    public function userReservation()
    {
        $user_id = auth()->id();

        if ($user_id) {
            $datas = DB::table('bookings')
                ->join('places', 'places.id', '=', 'bookings.place_id')
                ->join('users', 'users.id', '=', 'bookings.user_id')
                ->join('status', 'status.id', '=', 'bookings.status_id')
                ->select('places.*', 'bookings.*', 'status.*', 'users.name')
                ->where('user_id', $user_id)
                ->where('bookings.status_id', 1)
                ->get();

            if (!$datas->isEmpty()) {
                $response = [
                    'datas' => $datas,
                    'success' => true,
                    'status' => 200
                ];
                return response()->json($response, 200);
            }
            $response = [
                'datas' => $datas,
                'message' => "No data found",
                // 'success' => false,
                'status' => 200
            ];
            return response()->json($response, 200);
        }
        $response = [
            "success" => false,
            "messge" => "you must be connected",
            "status" => 401,
        ];
        return response()->json($response, 401);
    }

    // Cancelling a booking
    public function cancelBooking(Request $request, int $id)
    {
        $rules = [
            'place_id' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'validation error' => $validator->errors(),
                'status' => 500
            ];
            return response()->json($response, 501);
        }
        $placestatus = places::where('id', $request->input('place_id'))->first();
        $placestatus->status_id = 1;
        $placestatus->save();

        $booking = booking::where('place_id', $request->input('place_id'))
            ->where('status_id', 1)
            ->first();
        // $booking = booking::findOrFail($id);
        $booking->status_id = 3;
        $booking->save();
        if ($booking) {
            $response = [
                "booking" => $booking,
                "message" => "status updated successfully",
                "status" => 200
            ];
            return response()->json($response, 200);
        }
        $response = [
            "booking" => $booking,
            "success" => false,
            "status" => 500,
        ];
        return response()->json($response, 501);
    }

    // making a booking
    public function addBooking(Request $request)
    {
        $rules = [
            'user_id' => 'required',
            'place_id' => 'required',
            'status_id' => 'required'
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
        } else {
            $response = [
                'datas' => $datas,
                'success' => false,
                "status" => 500
            ];
            return response()->json($response, 500);
        }
    }


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
}
