<?php

namespace App\Http\Controllers\Frontend;


class PageController extends BaseController
{
    public function home()
    {
        return view('frontend.home');
    }
}
