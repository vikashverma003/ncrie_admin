<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
    public function __construct(){
     
    }

    public function index(){
        $totalAppUser=User::count();
       return view('admin.dashboard',['title'=>'dashboard',
       'user_count'=> $totalAppUser]);
    }
   
}
