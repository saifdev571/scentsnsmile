<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display the categories page
     */
    public function index()
    {
        return view('categories');
    }
}
