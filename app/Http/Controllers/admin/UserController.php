<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::orderBy('id','desc');

        if(!empty($request->get('keyword'))){
            $users = $users->where('name','like','%'.$request->get('keyword').'%');
            $users = $users->orWhere('email','like','%'.$request->get('keyword').'%');
        }

        $users = $users->paginate(10);
        $data['users'] = $users;

        return view('admin.users.list',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.users.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5',
            'status' => 'required|numeric',
            'phone' => 'required|numeric',
        ]);

        if($validate){
            $user = new User();

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->status = $request->status;
            $user->phone = $request->phone;

            $user->save();

            return redirect()->route('users.index')->with('success','User Added Successfully');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);

        if(empty($user)){
            return redirect()->route('error','Record Not Found');
        }

        $data['user'] = $user;
        return view('admin.users.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        if(empty($user)){
            return redirect()->route('error','Record Not Found');
        }
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id.',id',
            'status' => 'required|numeric',
            'phone' => 'required|numeric',
        ]);

        if($validate){

            $user->name = $request->name;
            $user->email = $request->email;
            if($user->password != null){
                $user->password = Hash::make($request->password);
            }
            
            $user->status = $request->status;
            $user->phone = $request->phone;

            $user->save();

            return redirect()->route('users.index')->with('success','User Edit Successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if($user == null){
            return redirect()->route('users.index')->with('error','User Not Found');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success','User Deleted Successfully');

    }
}
