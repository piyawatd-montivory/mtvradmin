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

class BlogController extends Controller
{
    function index()
    {
        return view('blog');
    }

    function category($slug)
    {
        return view('category');
    }

    function detail($slug)
    {
        return view('blogpost',['data'=>'','category'=>'binary-craft','categoryname'=>'Binary Craft']);
    }

    function tags($slug)
    {
        return view('tags');
    }

    function search($search)
    {
        return view('search',['data'=>["a","b"]]);
    }

    function noresult()
    {
        return view('search',['data'=>[]]);
    }
}
?>


