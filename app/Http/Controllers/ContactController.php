<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function contactFormHandler(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'full-name' => 'required|string|min:3|max:255',
            'message' => 'required|string|min:10|max:1000',
        ]);

        return redirect('/contact')->with('success', true);
    }
}
