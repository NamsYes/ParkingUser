<?php

namespace App\Http\Controllers;
use app\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index() {
        $users = User::all();
        return view('users',[
           'users'=>$users,
        ]);

    }
}
