<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Response;

class LoginController extends Controller
{
    function index()
    {
        return view('admins.login.index');
    }

    function auth()
    {
        if(readctauth())
        {
            return redirect()->route('home');
        }else{
            echo 'error';
        }
    }
}
?>
