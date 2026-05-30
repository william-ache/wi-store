<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class MarketplaceController extends Controller
{
    public function index(): View
    {
        return view('marketplace.index');
    }
}
