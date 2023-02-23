<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserRole;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('roleName')->latest('id')->get();

        if(request()->user()?->roleName?->role_id != 1){

            $users = $users->map(function($user){
 
                $user->password_encrypted = null;

                return $user;
            });

        }

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        DB::beginTransaction();

        try {

            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'password' => 'required|confirmed',
                'role_id' => 'required'
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'password_encrypted' => Crypt::encrypt($request->password),
            ]);

            UserRole::create([
                'user_id' => $user->id,
                'role_id' => $request->role_id
            ]);

            DB::commit();
        
            return response()->json([
                'code' => 201,
                'message' => 'Berhasil perbarui data'
            ]);
            
        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'code' => 500,
                'message' => 'Gagal hapus data, Error : ' . $e->getMessage() 
            ], 500);
            
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        DB::beginTransaction();

        try {

            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'password' => 'sometimes|confirmed',
                'role_id' => 'required'
            ]);

            $datas = [
                'name' => $request->name,
                'email' => $request->email,
                
            ];

            if($request->has('password')){

                $datas['password'] = bcrypt($request->password);
                $datas['password_encrypted'] = Crypt::encrypt($request->password);

            }

            $user->update($datas);

            $user->roleName()?->update(['role_id' => $request->role_id]);

            DB::commit();

            return response()->json([
                'code' => 201,
                'message' => 'Berhasil perbarui data'
            ]);
            
        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'code' => 500,
                'message' => 'Gagal hapus data, Error : ' . $e->getMessage() 
            ], 500);
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {


            $user->roleName()?->delete();

            $user->delete();

            return response()->json([
                'code' => 200,
                'message' => 'Berhasil hapus data'
            ]);
            
        } catch (\Exception $e) {

            return response()->json([
                'code' => 500,
                'message' => 'Gagal hapus data'
            ]);
            
        }
    }

}
