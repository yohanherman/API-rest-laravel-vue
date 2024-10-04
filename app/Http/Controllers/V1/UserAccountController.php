<?php

// namespace App\Http\Controllers\V1;

// use App\Models\User;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Validator;

// class UserAccountController
// {
//     public function editProfile(Request $request)
//     {

//         $rules = [
//             'name' => 'required|string',
//             'email' => 'required|email|exists:users'
//         ];
//         $validator = Validator::make($request->all(), $rules);
//         if ($validator->fails()) {
//             $response = [
//                 'sucess' => false,
//                 'Error' => $validator->errors(),
//                 'status' => 500
//             ];
//             return response()->json($response, 400);
//         }
//         $user = User::where('email', $request->input('email'))->first();
//         if ($user) {
//             $user->email = $request->email;
//             $user->name = $request->name;
//             $user->save();

//             $response = [
//                 'user' => $user,
//                 'success' => true,
//                 'message' => 'profile successsfully updated',
//                 'status' => 200
//             ];
//         }
//         $response = [
//             'success' => false,
//             'message' => " user not found",
//             'status' => 500,
//         ];
//         return response()->json($response, 500);
//     }
// }
