<?php

namespace App\Http\Controllers\V1;

use App\Models\places;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class placeController extends Controller
{
    public function index()
    {
        $datas = places::all();
        if (!$datas->isEmpty()) {
            $response = [
                'datas' => $datas,
                'success' => true,
                'status' => 200,
            ];
            return response()->json($response, 200);
        }
        $response = [
            'datas' => $datas,
            'success' => true,
            'status' => 200
        ];
        return response()->json($datas, 200);
    }

    public function show(int $id)
    {
        $datas = places::findOrFail($id);
        if (isset($datas)) {
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

    public function store(Request $request)
    {
        $rules = [
            'place_number' => 'required|',
            'status_id' => 'required|numeric'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => 'Validation Error.',
                $validator->errors(),
                'status' => 400
            ];
            return response()->json($response, 400);
        }

        $datas = places::create($request->all());
        if (isset($datas)) {
            $response = [
                'datas' => $datas,
                'success' => true,
                'status' => 200,
                'message' => 'successfully created'
            ];
            return response()->json($response, 201);
        }
        $response = [
            'datas' => $datas,
            'success' => false,
            'status' => 500
        ];
        return response()->json($response, 501);
    }

    public function destroy(int $id)
    {
        $datas = places::where('id', $id)->first();
        $datas->delete();
        return response()->json($datas, 204);
    }


    public function update(Request $request, int $id)
    {
        $rules = [
            "place_number" => 'required',
            "status_id" => 'required|numeric',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => 'Validation Error.',
                $validator->errors(),
            ];
            return response()->json($response, 400);
        }

        $datas = places::where('id', $id)->first();
        $datas->update($request->all());

        if (isset($datas)) {
            $response = [
                'datas' => $datas,
                'success' => true,
                'status' => 202,
                'message' => 'successfully updated',
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

    // places en fonction des coordonnees geographiques du users
    public function getParkingNearby(Request $request)
    {
        $rules = [
            'longitude' => 'required',
            "latitude" => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'validation Error' . $validator->errors(),
                'status' => 400
            ];
            return response()->json($response, 500);
        }
        $longitude = $request->input('longitude');
        $latitude = $request->input('latitude');

        // j'utilise la formule d' Haversine
        $datas = DB::table('places')
            ->select(DB::raw("*, ( 6371 * acos( cos( radians ($latitude) ) 
            * cos( radians( latitude) ) * cos( radians( longitude ) - radians( $longitude ) ) 
            + sin( radians( $latitude ) ) * sin( radians( latitude) ) ) ) AS distance"))
            ->having('distance', '<', 500)
            ->orderby('distance')
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
            'success' => false,
            "message" => "no place in the radius of 50 kilometers",
            'status' => 404
        ];
        return response()->json($response, 404);
    }
}
