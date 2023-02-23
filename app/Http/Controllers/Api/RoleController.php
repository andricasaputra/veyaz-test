<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::latest('id')->get();

        return RoleResource::collection($roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                'name' => 'required'
            ]);

            Role::create([
                'name' => $request->name
            ]);
        
            return response()->json([
                'code' => 201,
                'message' => 'Berhasil perbarui data'
            ]);
            
        } catch (\Exception $e) {

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
    public function update(Request $request, Role $role)
    {
        try {

            $request->validate([
                'name' => 'required'
            ]);

            $role->update([
                'name' => $request->name
            ]);

            return response()->json([
                'code' => 201,
                'message' => 'Berhasil perbarui data'
            ]);
            
        } catch (\Exception $e) {

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
    public function destroy(Role $role)
    {
        try {

            $role->delete();

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
