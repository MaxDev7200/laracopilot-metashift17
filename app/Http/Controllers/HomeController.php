<?php

namespace App\Http\Controllers;

use App\Models\FeatureFlag;

class HomeController extends Controller
{
    public function index()
    {
        $totalFeatures = FeatureFlag::count();
        $activeFeatures = FeatureFlag::where('is_enabled', true)->count();
        
        return view('welcome', compact('totalFeatures', 'activeFeatures'));
    }
}