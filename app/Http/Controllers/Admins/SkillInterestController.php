<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\SkillInterest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SkillInterestController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->contenttypeid = 'skillInterests';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        $data = new \stdClass;
        $data->skills = [];
        $data->interests = [];
        if(count($resObj->items) > 0){
            $data->id = $resObj->items[0]->sys->id;
            $data->version = $resObj->items[0]->sys->version;
            $data->skills = $resObj->items[0]->fields->skills->{'en-US'};
            $data->interests = $resObj->items[0]->fields->interests->{'en-US'};
        }
        return view('admins.skill.form', [ 'data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = json_decode($request->data);
        $json = new \stdClass;
        $json->fields = new \stdClass;
        $json->fields->name = new \stdClass;
        $json->fields->name->{'en-US'} = 'Skill & Interests';
        $json->fields->skills = new \stdClass;
        $json->fields->skills->{'en-US'} = $data->skills;
        $json->fields->interests = new \stdClass;
        $json->fields->interests->{'en-US'} = $data->interests;
        if($data->id == ''){
            $response = Http::withBody(json_encode($json), 'application/vnd.contentful.management.v1+json')
            ->withHeaders([
                'X-Contentful-Content-Type' => $this->contenttypeid,
                'Content-Type' => 'application/vnd.contentful.management.v1+json'
            ])
            ->withToken(config('app.cmaaccesstoken'))
            ->post(getCtUrl().'/entries');
            $data->id = $response->json('sys.id');
        }else{
            $response = Http::withBody(json_encode($json), 'application/vnd.contentful.management.v1+json')
            ->withHeaders([
                'X-Contentful-Content-Type' => $this->contenttypeid,
                'Content-Type' => 'application/vnd.contentful.management.v1+json',
                'X-Contentful-Version' => intval($data->version)
            ])
            ->withToken(config('app.cmaaccesstoken'))
            ->put(getCtUrl().'/entries/'.$data->id);
        }
        //publish
        $response = Http::withHeaders([
            'X-Contentful-Version' => intval($response->json('sys.version'))
        ])
        ->withToken(config('app.cmaaccesstoken'))
        ->put(getCtUrl().'/entries/'.$data->id.'/published');
        $resObj = $response->object();
        generateSkill();
        return $resObj;
    }
}
