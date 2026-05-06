<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function getWelcomeData()
    {
        return [
            'greeting' => 'Hello',
            'person' => request('person', 'my dear visitor'),
        ];
    }

    public function showWelcomePage()
    {
        return view('welcome', $this->getWelcomeData());
    }

    public function showAboutPage()
    {
        return view('about');
    }

    public function showContactPage()
    {
        return view('contact');
    }

    public function addWelcomeData(array $data = [])
    {
        return array_merge($this->getWelcomeData(), $data);
    }
}