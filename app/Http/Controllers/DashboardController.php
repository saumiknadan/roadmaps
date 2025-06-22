<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        try {
            return view('admin.dashboard');

        } catch (\Throwable $th) {
            session()->flash('error', 'Something went wrong');
            return redirect()->back();
        }
    }
}
