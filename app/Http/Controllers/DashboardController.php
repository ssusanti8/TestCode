<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    //
    public function index()
    {
    // return view('home')
    $users = User::all();
    return view('dashboard', [
        'users' => $users,
        'title' => 'dashboard'
    ]);
}
}
