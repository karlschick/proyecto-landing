<?php

namespace App\Http\Controllers;

use App\Services\CacheService;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // Usar caché para settings
        $settings = CacheService::settings();

        return view('landing.index', compact('settings'));
    }
}
