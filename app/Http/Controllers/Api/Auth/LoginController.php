<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        try {

            $request->validate([
                'email' => ['required'],
                'password' => ['required']
            ]);
            
            if (! auth()->attempt([
                    'email' => $request->email,
                    'password' => $request->password,
                ])) {

                 return response()->json([
                    'message' => 'Identitas tersebut tidak cocok dengan data kami.'
                ], 401);
            }

            $user = auth()->user();

            return response()->json([
                'code' => 200,
                'token' => $user->createToken('access_token')->plainTextToken,
            ], 200);
            
        } catch (\Exception $e) {

            return response()->json([
                'code' => 401,
                'message' => 'Unauthorized!',
            ], 401);
            
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'code' => 200
        ]);
    }
}
