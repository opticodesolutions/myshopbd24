<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

use App\Models\Purchase;

use App\Models\JobsPost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\IncentiveIncome;
use App\Models\Sale;
use App\Models\Subscription;

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

        $subscriptions = Subscription::get();
        return view('frontend.pages.index', compact('categories','products','packages', 'subscriptions'));
    }

    public function joining_job(){
        $categories = Category::with('user','media')->get();
        //$products = Product::with(['category', 'brand'])->get();
        // Normal Products For Perchase
        $products = Product::with(['category', 'brand'])
        ->whereDoesntHave('category', function($query) {
            $query->where('name', 'package');
        })
        ->get();
        return view('frontend.pages.products.form', compact('categories'));
    }
    
    
    public function job_post_save(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string',
            'father_name' => 'required|string',
            'mother_name' => 'required|string',
            'voter_id' => 'required|string',
            'mobile_number' => 'required|string',
            'district' => 'required|string',
            'upazila' => 'required|string',
            'union' => 'required|string',
            'ward_no' => 'required|string',
            'village_name' => 'required|string',
            'nationality' => 'required|string',
            'religion' => 'required|string',
            'passport_image' => 'nullable|image|max:2048',
        ]);

        // Handle passport image upload if present
        $passportImagePath = null;
        if ($request->hasFile('passport_image')) {
            $passportImagePath = $request->file('passport_image')->store('passport_images', 'public');
        }

        // Store the job application data in the jobs_post table
        JobsPost::create([
            'name' => $request->name,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'voter_id' => $request->voter_id,
            'mobile_number' => $request->mobile_number,
            'district' => $request->district,
            'upazila' => $request->upazila,
            'union' => $request->union,
            'ward_no' => $request->ward_no,
            'village_name' => $request->village_name,
            'nationality' => $request->nationality,
            'religion' => $request->religion,
            'passport_image' => $passportImagePath,
        ]);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Job application submitted successfully!');
    }
    
    public function job_list()
    {
        $jobs = JobsPost::all(); 
        return view('super-admin.job.job_list', compact('jobs'));
    }
    
        public function job_show($id)
    {
        $job = JobsPost::findOrFail($id);
        return view('super-admin.job.job', compact('job'));
    }
    public function join_invoice()
    {
        if (auth()->check()) {
            $purchase = Sale::with('product')->where('customer_id', auth()->user()->id)->first();
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
            $incentiveIncomes = IncentiveIncome::paginate(10);
            return view('commissions.insensitive_income', compact('incentiveIncomes'));
        }else{
            return redirect('/login');
        }
    }

    public function insensitive_info(){
        if (auth()->check()) {
            $incentiveIncomes = IncentiveIncome::paginate(10);
            return view('commissions.insensitive_income', compact('incentiveIncomes'));
        }else{
            return redirect('/login');
        }
    }
}
