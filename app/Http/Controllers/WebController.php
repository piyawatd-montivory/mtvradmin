<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Response;

class WebController extends Controller
{
    function index()
    {
        return view('index');
    }

    function career()
    {
        return view('career');
    }

    function careerfinish()
    {
        return view('careerfinish');
    }

    function ck()
    {
        return view('ckeditor');
    }
}
?>


