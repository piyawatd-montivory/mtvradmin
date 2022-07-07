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
use App\Models\Partner;
use App\Models\Content;
use App\Models\SkillInterest;
use App\Models\Position;

class WebController extends Controller
{
    function index()
    {
        $partners = Partner::orderBy('sortorder','asc')->get();
        $testimonials = Content::where('contenttype','testimonial')
            ->orderBy('sortorder','asc')->get();
        $positions = Position::where('status_active',true)->orderBy('position','asc')->get();
        return view('index',['partners'=>$partners,'testimonials'=>$testimonials,'positions'=>$positions]);
    }

    function career()
    {
        $benefitGallery = [];
        $benefit = Content::where('alias','benefit')->first();
        if($benefit){
            $benefitGallery = json_decode($benefit->gallery);
        }
        $skills = SkillInterest::where('type','skill')
        ->orderBy('name', 'asc')->get();
        $interests = SkillInterest::where('type','interest')
        ->orderBy('name', 'asc')->get();
        return view('career',['benefitGallery'=>$benefitGallery,'skills'=>$skills,'interests'=>$interests]);
    }

    function careerdetail($alias)
    {
        return view('careerdetail',['position'=>Position::where('alias',$alias)->get()->first()]);
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


