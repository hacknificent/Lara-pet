<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function contactFormHandler(Request $request)
    {
        return redirect('/contact')->with('success', true);
    }
}
