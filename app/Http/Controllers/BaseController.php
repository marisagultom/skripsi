<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        
        $url = request()->url();
        $projectId = (substr($url, -1));
        $array = (explode('/', $url));
        if (isset($array[4])) {
            view()->share('projectId', $array[4]);
        }
    }
}
