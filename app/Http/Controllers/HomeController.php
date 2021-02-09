<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\GalleryImage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $events = Event::where('enabled', true)
                        ->where('published', true)
                        ->where('major', false)
                        ->where('featured', true)
                        ->limit(3)
                        ->get();

        $majorEvent = Event::where('enabled', true)
                        ->where('published', true)
                        ->where('major', true)
                        ->first();

        $galleryImages = GalleryImage::where('enabled', true)->limit(4)->get();

        return view('public.home.index', compact('events', 'majorEvent', 'galleryImages'));
    }
}
