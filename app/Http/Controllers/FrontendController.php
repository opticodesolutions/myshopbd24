<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

use App\Models\Purchase;
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

    public function join_invoice()
    {
        if (auth()->check()) {
            $purchase = Purchase::with('product')->where('user_id', auth()->user()->id)->first();
            if ($purchase == null) {
              return redirect()->back()->with('error', 'You have not purchased any Package yet');
            }else {
                return view('frontend.pages.join_invoice', compact('purchase'));
            }
        }else {
            # code...
            return redirect('/login');
        }
    }

    public function insensitive_income(){
        if (auth()->check()) {
            return view('commissions.insensitive_income');
        }else{
            return redirect('/login');
        }
    }

    public function insensitive_info(){
        if (auth()->check()) {
            return view('commissions.insensitive_income');
        }else{
            return redirect('/login');
        }
    }
}
