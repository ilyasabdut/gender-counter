<?php

namespace App\Http\Controllers;

use Arr;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::orderBy('created_at')
                ->when(request()->filled('search'), function ($query) {
                    $search = '%'.ucwords(request('search')).'%';
                    $query->whereRaw("name->'name'->>'first' LIKE ?", [$search])
                        ->orWhereRaw("name->'name'->>'last' LIKE ?", [$search])
                        ->orWhereRaw("name->'name'->>'title' LIKE ?", [$search]);
                })
                ->get();
                
        return api('success',200,$user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user)
    {
        DB::beginTransaction();
        try {
            $find = User::firstWhere('uuid',$user);
            
            if(is_null($find)){
                return api(null,'user not found',422);
            }
            $find->delete();
            DB::commit();
            return api('user deleted',200,$find);

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
