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
        $positionarrayquery['fields.active'] = "true";
        $positionarrayquery['order'] = "fields.title";
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
        $positionarrayquery = array("content_type"=>"position");
        $positionarrayquery['fields.active'] = "true";
        $positionarrayquery['order'] = "fields.title";
        $positionresponse = Http::withToken(config('app.cdaaccesstoken'))
        ->get(getCtCdaUrl().'/entries',$positionarrayquery);
        $positionresult = $positionresponse->object();
        $arrayquery = array("content_type"=>"pagecontent");
        $arrayquery['fields.page[in]'] = "career";
        $response = Http::withToken(config('app.cdaaccesstoken'))
        ->get(getCtCdaUrl().'/entries',$arrayquery);
        $result = $response->object();
        $page = new \stdClass;
        foreach($result->items as $item){
            switch($item->fields->session[0]){
                case 'why-montivory':
                    $data = new \stdClass;
                    $data->title = $item->fields->title;
                    $data->content = $item->fields->content;
                    $page->montivory = $data;
                    break;
                case 'benefit':
                    $data = new \stdClass;
                    $data->title = $item->fields->title;
                    $data->content = $item->fields->content;
                    $data->gallery = $item->fields->gallery;
                    $page->benefit = $data;
                    break;
                case 'footer':
                    $data = new \stdClass;
                    $data->special = $item->fields->special;
                    $data->content = $item->fields->content;
                    $page->footer = $data;
                    break;
            }
        }
        $result = getGenerateCustomFile('skill.json');
        if($result){
            $resObj = getGenerateCustomFile('skill.json');
        }else{
            $arrayquery = array("content_type"=>$this->contenttypeid);
            $arrayquery['limit'] = 1;
            $response = Http::withToken(config('app.cmaaccesstoken'))
            ->get(getCtUrl().'/entries',$arrayquery);
            $resObj = $response->object();
        }
        $skills = [];
        $interests = [];
        if(count($resObj->items) > 0){
            $skills = $resObj->items[0]->fields->skills->{'en-US'};
            $interests = $resObj->items[0]->fields->interests->{'en-US'};
        }
        return view('career',['data'=>$page,'skills'=>$skills,'interests'=>$interests,'positions'=>$positionresult->items]);
    }

    function careerdetail($alias)
    {
        $data = [];
        $query = 'query positionCollectionQuery {
            positionCollection (
                where:
                    {
                        slug:"'.$alias.'"},
                limit:1
            ) {
                items {
                    sys {
                        id
                    }
                title,
                slug,
                thumbnail {
                  url
                },
                description,
                ogtitle,
                ogdescription,
                ogimage {
                  url
                },
                keyword
              }
            }
        }';
        $response = Http::withBody(json_encode([
            'query' => $query
        ]),'')
            ->withToken(config('app.cdaaccesstoken'))
            ->post(getCtGraphqlUrl());
        $resObj = $response->object();
        //footer
        $arrayquery = array("content_type"=>"pagecontent");
        $arrayquery['fields.session[in]'] = "footer";
        $arrayquery['limit'] = 1;
        $response = Http::withToken(config('app.cdaaccesstoken'))
        ->get(getCtCdaUrl().'/entries',$arrayquery);
        $result = $response->object();
        $page = new \stdClass;
        foreach($result->items as $item){
            switch($item->fields->session[0]){
                case 'footer':
                    $data = new \stdClass;
                    $data->special = $item->fields->special;
                    $data->content = $item->fields->content;
                    $page->footer = $data;
                    break;
            }
        }
        return view('careerdetail',['data'=>$page,'position'=>$resObj->data->positionCollection->items[0]]);
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


