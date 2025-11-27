<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AdminController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware('role:super_admin,admin,trainer,member,guest'),
        ];
    }

    public function index() {
        $title = 'Admin Dashboard';
        $memberCount = Member::count();
        return view('admin.index', compact('title', 'memberCount'));
    }
}
