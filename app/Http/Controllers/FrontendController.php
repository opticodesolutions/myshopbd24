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
        $products = Product::with(['category', 'brand'])->get();
        //return $products;
        return view('frontend.pages.index', compact('categories','products'));
    }
}
