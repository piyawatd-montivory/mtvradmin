<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\Content;
use Auth;


class FileManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function images()
    {
        return view('admins.filemanager.images');
    }

    public function files()
    {
        return view('admins.filemanager.files');
    }


}
