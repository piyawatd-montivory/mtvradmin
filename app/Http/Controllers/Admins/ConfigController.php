<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Response;

class ConfigController extends Controller
{

    public function __construct()
    {

    }

    function index(Request $request)
    {
        generateSkill();
        // generateCategory();
        // generateRole();
        // generatePseudonym();

        if(authuser()){
            return view('config');
        }
        return redirect()->route('signin');
    }
}
