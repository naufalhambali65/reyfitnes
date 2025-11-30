<?php

namespace App\Http\Controllers;

use App\Models\GymClass;
use App\Models\Membership;
use App\Models\Trainer;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index() {

        $memberships = Membership::all();
        $trainers = Trainer::where('status', 'active')->get();
        $gymClasses = GymClass::where('status', 'active')->get();
        return view('homepage.index', compact('memberships', 'trainers', 'gymClasses'));
    }

    public function about() {
        $trainers = Trainer::where('status', 'active')->get();
        return view('homepage.about.index', compact('trainers'));
    }

    public function bmi() {
        return view('homepage.bmi.index');
    }

    public function contact()
    {
        return view('homepage.contact.index');
    }
}