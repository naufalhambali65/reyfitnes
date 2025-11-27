<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class DashboardController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware('role:super_admin,admin,trainer,member,guest', only: ['index']),
        ];
    }
    public function index() {
        $title = 'Dashboard';
        $memberCount = Member::count();
        return view('dashboard.index', compact('title', 'memberCount'));
    }
}