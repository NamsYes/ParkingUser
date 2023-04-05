<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Second extends Controller
{
    public function second () {
        $results = [
            'policier',
            'pompier',
        ];

        return view('second',compact('results'));
    }
}
