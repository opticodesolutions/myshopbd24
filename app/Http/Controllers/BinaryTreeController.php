<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;

use App\Models\Customer;

class BinaryTreeController extends Controller
{
    private $tree;
    public function __construct(Helpers $helpers)
    {
        $this->tree = $helpers;
    }

    /**
     * Show MLM Tree.
     */
    public function showTree()
    {
        $refercode = Customer::with('user')->where('user_id', auth()->user()->id)->first();
        $rootReferCode = $refercode->refer_code;
        $tree = $this->tree->getTree($rootReferCode);

        // return $tree;
        return view('binary-tree', compact('tree'));
    }
}
