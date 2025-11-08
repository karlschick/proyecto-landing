<?php

namespace App\Http\Controllers;

use App\Services\CacheService;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $settings = CacheService::settings();
        $services = CacheService::services();
        $projects = CacheService::projects();
        $testimonials = CacheService::testimonials();
        $gallery = CacheService::gallery();
        $products = CacheService::products(); // 👈 añadimos esto

        return view('landing.index', compact(
            'settings', 'services', 'projects', 'testimonials', 'gallery', 'products'
        ));
    }
}
