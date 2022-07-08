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
use App\Models\TeamMontivory;

class WebController extends Controller
{
    function index()
    {
        $partners = Partner::orderBy('sortorder','asc')->get();
        $testimonials = Content::where('contenttype','testimonial')
            ->orderBy('sortorder','asc')->get();
        $positions = Position::where('status_active',true)->orderBy('position','asc')->get();
        $teams = TeamMontivory::where('status_active',true)->orderBy('sortorder','asc')->get();
        return view('index',['partners'=>$partners,'testimonials'=>$testimonials,'positions'=>$positions,'teams'=>$teams]);
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
        $contents = [];
        $contentOne = Content::where('alias','careerfinish-1')->get()->first();
        if($contentOne){
            array_push($contents,$contentOne);
        }
        $contentTwo = Content::where('alias','careerfinish-2')->get()->first();
        if($contentTwo){
            array_push($contents,$contentTwo);
        }
        $contentThree = Content::where('alias','careerfinish-3')->get()->first();
        if($contentThree){
            array_push($contents,$contentThree);
        }
        return view('careerfinish',['contents'=>$contents]);
    }

    function ck()
    {
        return view('ckeditor');
    }
}
?>


