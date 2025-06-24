<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        try{
            $users = User::paginate(10);

            return view('admin.users.index', compact('users'));

        } catch (\Throwable $th) {
            session()->flash('error', 'Something went wrong');
            return redirect()->back();
        }    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|max:100|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);
        
        try{
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            
            return redirect()->back()->with('success', 'User has been created !!');
        }catch (\Exception $e){
            session()->flash('error', 'Something went wrong !!');
            return redirect()->back();
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
    public function edit( $id)
    {
        $user = User::find($id);
        return view('admin.users.edit', compact('user'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|max:100|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        try{
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            return redirect()->back()->with('success', 'User has been updated !!');
        }catch (\Exception $e){
            session()->flash('error', 'Something went wrong !!');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->back()->with('success', 'User has been deleted successfully');
        }catch (\Exception $e){
            session()->flash('error','Something went wrong');
            return redirect()->back();
        }
    }
}
