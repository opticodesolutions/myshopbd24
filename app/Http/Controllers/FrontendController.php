<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontendController extends Controller
{
    public function index()
    {
        $categories = Category::with('user','media')->get();
        //$products = Product::with(['category', 'brand'])->get();
        // Normal Products For Perchase
        $products = Product::with(['category', 'brand'])
        ->whereDoesntHave('category', function($query) {
            $query->where('name', 'package');
        })
        ->get();

        // Packages For Sell And Register User
        $packages = Product::with(['category', 'brand'])->whereHas('category', function($query)
        {$query->where('name', 'package');})
        ->get();
        return view('frontend.pages.index', compact('categories','products','packages'));
    }
}
