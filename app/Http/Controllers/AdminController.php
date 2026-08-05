<?php

namespace App\Http\Controllers;

use App\Models\User;

class AdminController extends Controller
{
    private int $perPage = 25;

    public function __construct()
    {
        $this->middleware('can:view-admin-panel');
    }

    public function index()
    {
        $perPage = $this->getPerPage();
        $users = User::with('projects')->paginate($perPage);

        return view('admin', compact('users', 'perPage'));
    }

    private function getPerPage(): int
    {
        return $this->perPage;
    }
}
