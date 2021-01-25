<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Movie;

class WelcomeController extends Controller
{
    public function index(){
        $latest_movies = Movie::latest()->limit(3)->get();

        $categories = Category::with('movies')->get();

        $view_movies = Movie::orderBy('views', 'desc')->limit(5)->get();

        return view('welcome',compact('latest_movies','categories','view_movies'));
    }
}
