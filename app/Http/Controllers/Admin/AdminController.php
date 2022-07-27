<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        if(!Auth::check()){
            return redirect()->route('admin.login');
        }
    }
    
    public function index()
    {
        if(Auth::check()){
            return view('admin.index');
        }
        return redirect()->route('admin.index');
    }
}
