<?php

namespace App\Http\Controllers;

use App\Models\GalleryImage;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $galleryImages = GalleryImage::where('enabled', true)->limit(4)->get();

        return view('public.gallery.index', compact('galleryImages'));
    }
}
