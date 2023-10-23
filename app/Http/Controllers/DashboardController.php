<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Models\Pengumuman;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function index()
    {
    // return view('home')
    $users = User::all();
    $user_id = Auth::user()->id;
    $pengumumans = Pengumuman::all();
    return view('dashboard', compact('pengumumans'), [
        'users' => $users,
        'title' => 'dashboard'
    ]);
}
}
