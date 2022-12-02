<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Response;

class TagController extends Controller
{

    public function __construct()
    {

    }

    function index(Request $request)
    {
        return view('admins.image.index');
    }

    function new(Request $request)
    {
        return view('admins.tag.form',['CKEditorFuncNum' => $request->input('CKEditorFuncNum')]);
    }

    function newpopup(Request $request)
    {
        return view('admins.tag.formpopup',['type'=>$request->type]);
    }


}
