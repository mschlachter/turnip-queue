<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index()
    {
    	return view('donate.index');
    }

    public function thankYou()
    {
    	return view('donate.thank-you');
    }
}
