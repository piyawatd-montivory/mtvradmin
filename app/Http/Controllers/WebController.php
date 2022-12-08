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
        $positionarrayquery = array("content_type"=>"position");
        $positionresponse = Http::withToken(config('app.cdaaccesstoken'))
        ->get(getCtCdaUrl().'/entries',$positionarrayquery);
        $positionresult = $positionresponse->object();
        $arrayquery = array("content_type"=>"pagecontent");
        $arrayquery['fields.page[in]'] = "index";
        $response = Http::withToken(config('app.cdaaccesstoken'))
        ->get(getCtCdaUrl().'/entries',$arrayquery);
        $result = $response->object();
        $page = new \stdClass;
        $page->partner = [];
        $page->footer =  new \stdClass;
        foreach($result->items as $item){
            switch($item->fields->session[0]){
                case 'first':
                    $data = new \stdClass;
                    $data->title = $item->fields->title;
                    $data->content = $item->fields->content;
                    $page->first = $data;
                    break;
                case 'team-montivory':
                    $data = new \stdClass;
                    $data->title = $item->fields->title;
                    $data->content = $item->fields->content;
                    $page->team = $data;
                    break;
                case 'third':
                    $data = new \stdClass;
                    $data->title = $item->fields->title;
                    $data->content = $item->fields->content;
                    $page->third = $data;
                    break;
                case 'partner':
                    $page->partner = $item->fields->gallery;
                    break;
                case 'provide':
                    $data = new \stdClass;
                    $data->title = $item->fields->title;
                    $data->content = $item->fields->content;
                    $data->gallery = $item->fields->gallery;
                    $page->provide = $data;
                    break;
                case 'footer':
                    $data = new \stdClass;
                    $data->special = $item->fields->special;
                    $data->content = $item->fields->content;
                    $page->footer = $data;
                    break;
            }
        }
        return view('index',['data'=>$page,'positions'=>$positionresult->items]);
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
        $positions = Position::where('status_active',true)->orderBy('position','asc')->get();
        // $data = new \stdClass;
        // $data->footer = new \stdClass;
        return view('career',['benefitGallery'=>$benefitGallery,'skills'=>$skills,'interests'=>$interests,'positions'=>$positions]);
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


