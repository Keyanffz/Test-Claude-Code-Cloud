<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Support\Portfolio;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(Portfolio $portfolio): View
    {
        return view('site.home', $portfolio->home());
    }
}
