<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users=User::orderBy('id','DESC')->get();
        return view('backend.users.index',compact('users'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,
            [
                'full_name'=>'string|required|max:30',
                'username'=>'string|nullable',
                'email'=>'string|required|unique:users,email',
                'password'=>'string|required',
                'phone'=>'string|nullable',
                'photo'=>'nullable|string',
                'address'=>'string|nullable',
                'role'=>'required|in:admin,customer,vendor',
                'status'=>'required|in:active,inactive',
            ]);
        $data=$request->all();
        $data['password']=Hash::make($request->password);
        $status=User::create($data);
        if($status){
            return redirect()->route('user.index')->with('success','Successfully added user');
        }
        else{
           return back()->with('error','Error occurred while adding user');
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
        $user=User::findOrFail($id);
        if ($user){
            return view('backend.users.edit',compact('user'));
        }
        else{
            return back()->with('error','User Not Found');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user=User::findOrFail($id);
        $this->validate($request,
            [
                'full_name'=>'string|required|max:30',
                'username'=>'string|nullable',
                'email'=>'string|required|exists:users,email',
                'phone'=>'string|nullable',
                'photo'=>'nullable|string',
                'address'=>'string|nullable',
                'role'=>'required|in:admin,customer,vendor',
                'status'=>'required|in:active,inactive',
            ]);
        $data= $request->all();
        $status=$user->fill($data)->save();
        if($status){
            return redirect()->route('user.index')->with('success','User Has Been Updated Successfully ');
        }
        else{
            return back()->with('error','Error Occurred While Updating User!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete=User::findorFail($id);
        $status=$delete->delete();
        if($status) {
            if ($status) {
                return redirect()->route('user.index')->with('success', 'User Has Been Deleted Successfully ');
            } else {
                return back()->with('error', 'Error Occurred While Deleting User!');
            }
        }
}

    //    public function userStatus(Request $request)
//    {
//        if($request->mode=='true'){
//            DB::table('users')->where('id',$request->id)->update(['status'=>'active']);
//        }
//        else{
//            DB::table('users')->where('id',$request->id)->update(['status'=>'inactive']);
//
//        }
//        return response()->json([
//            'msg'=>'user Has Been Updated Successfully ','status'=>true
//        ]);
//    }
}
