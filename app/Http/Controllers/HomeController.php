<?php

namespace App\Http\Controllers;

use App\Social;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $acc = Social::where('user_id', auth()->id())->get();

        return view('home', compact('acc'));
    }
}
