<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function __construct()
    {
        $this->contenttypeid = 'user';
    }

    function index(Request $request)
    {
        return view('admins.user.index');
    }

    function new(Request $request)
    {
        $roles = getRole();
        $data = new \stdClass;
        $data->id = '';
        $data->version = 0;
        $data->password = '';
        $data->email = '';
        $data->firstname = '';
        $data->lastname = '';
        $data->type = $request->type;
        $data->profileimageid = '';
        $data->profileimage = '';
        $data->role = 'article';
        $data->active = true;
        $data->default = false;
        $data->pseudonyms = [];
        return view('admins.user.form',['data'=>$data,'roles'=>$roles]);
    }

    function edit($id,Request $request)
    {
        $id = $request->id;
        $response = Http::withToken(config('app.cmaaccesstoken'))
        ->get(getCtUrl().'/entries/'.$id);
        $resObj = $response->object();
        $roles = getRole();
        $data = new \stdClass;
        $data->id = $resObj->sys->id;
        $data->version = $resObj->sys->version;
        $data->type = 'system';
        $data->password = $resObj->fields->password->{'en-US'};
        $data->firstname = $resObj->fields->firstname->{'en-US'};
        $data->lastname = $resObj->fields->lastname->{'en-US'};
        $data->email = isset($resObj->fields->email->{'en-US'})?$resObj->fields->email->{'en-US'}:'';
        $data->role = $resObj->fields->role->{'en-US'};
        $data->active = $resObj->fields->active->{'en-US'};
        $data->default = isset($resObj->fields->default->{'en-US'})?$resObj->fields->default->{'en-US'}:false;
        $data->pseudonyms = getPseudonym($resObj->sys->id,true,false);
        return view('admins.user.form',['data'=>$data,'roles'=>$roles]);
    }

    function update(Request $request)
    {
        $data = json_decode($request->data);
        $json = new \stdClass;
        $json->fields = new \stdClass;
        $oldpassword = $data->oldpassword;
        if(empty($data->password)){
            $json->fields->password = new \stdClass;
            $json->fields->password->{'en-US'} = $oldpassword;
        }else{
            $oldpassword = Hash::make($data->password);
            $json->fields->password = new \stdClass;
            $json->fields->password->{'en-US'} = $oldpassword;
        }
        $json->fields->email = new \stdClass;
        $json->fields->email->{'en-US'} = $data->email;
        $json->fields->firstname = new \stdClass;
        $json->fields->firstname->{'en-US'} = $data->firstname;
        $json->fields->lastname = new \stdClass;
        $json->fields->lastname->{'en-US'} = $data->lastname;
        $json->fields->role = new \stdClass;
        $json->fields->role->{'en-US'} = $data->role;
        $json->fields->active = new \stdClass;
        $json->fields->active->{'en-US'} = $data->active;
        $json->fields->default = new \stdClass;
        $json->fields->default->{'en-US'} = $data->default;
        // return $json;
        if($data->id == ''){
            $response = Http::withBody(json_encode($json), 'application/vnd.contentful.management.v1+json')
            ->withHeaders([
                'X-Contentful-Content-Type' => $this->contenttypeid,
                'Content-Type' => 'application/vnd.contentful.management.v1+json'
            ])
            ->withToken(config('app.cmaaccesstoken'))
            ->post(getCtUrl().'/entries');
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
        $response = Http::withHeaders([
            'X-Contentful-Version' => $response->json('sys.version')
        ])
        ->withToken(config('app.cmaaccesstoken'))
        ->put(getCtUrl().'/entries/'.$response->json('sys.id').'/published');
        $result = $response->object();
        $result->password = $oldpassword;
        if($data->type == 'profile'){
            $user = $response->object();
            $profile = new \stdClass;
            $profile->id = $user->sys->id;
            $profile->email = $user->fields->email->{'en-US'};
            $profile->password = $oldpassword;
            $profile->role = $user->fields->role->{'en-US'};
            $profile->firstname = $user->fields->firstname->{'en-US'};
            $profile->lastname = $user->fields->lastname->{'en-US'};
            $profile->pseudonyms = getPseudonym($user->sys->id);
            session(['user' => $profile]);
        }
        generatePseudonym();
        return $result;
    }

    function profile(Request $request)
    {
        $categories = getCategory();
        $id = authuser()->id;
        $response = Http::withToken(config('app.cmaaccesstoken'))
        ->get(getCtUrl().'/entries/'.$id);
        $resObj = $response->object();
        $data = new \stdClass;
        $data->id = $resObj->sys->id;
        $data->type = 'profile';
        $data->version = $resObj->sys->version;
        $data->password = $resObj->fields->password->{'en-US'};
        $data->email = $resObj->fields->email->{'en-US'};
        $data->firstname = $resObj->fields->firstname->{'en-US'};
        $data->lastname = $resObj->fields->lastname->{'en-US'};
        $data->role = $resObj->fields->role->{'en-US'};
        $data->active = $resObj->fields->active->{'en-US'};
        $data->default = $resObj->fields->default->{'en-US'};
        $data->pseudonyms = getPseudonym($resObj->sys->id,true,false);
        return view('admins.user.profile',['data'=>$data]);
    }

    function updatepenname(Request $request)
    {
        $data = json_decode($request->data);
        $json = new \stdClass;
        $json->fields = new \stdClass;
        $json->fields->name = new \stdClass;
        $json->fields->name->{'en-US'} = $data->name;
        $json->fields->title = new \stdClass;
        $json->fields->title->{'en-US'} = $data->title;
        $json->fields->description = new \stdClass;
        $json->fields->description->{'en-US'} = $data->description;
        $json->fields->default = new \stdClass;
        $json->fields->default->{'en-US'} = $data->default;
        //user
        $json->fields->user = new \stdClass;
        $json->fields->user->{'en-US'} = new \stdClass;
        $json->fields->user->{'en-US'}->sys = new \stdClass;
        $json->fields->user->{'en-US'}->sys->type = "Link";
        $json->fields->user->{'en-US'}->sys->linkType = "Entry";
        $json->fields->user->{'en-US'}->sys->id = $data->uid;
        //profileimage
        $json->fields->profileimage = new \stdClass;
        $json->fields->profileimage->{'en-US'} = new \stdClass;
        $json->fields->profileimage->{'en-US'}->sys = new \stdClass;
        $json->fields->profileimage->{'en-US'}->sys->type = "Link";
        $json->fields->profileimage->{'en-US'}->sys->linkType = "Asset";
        $json->fields->profileimage->{'en-US'}->sys->id = $data->mid;
        // return $json;
        if($data->id == ''){
            $response = Http::withBody(json_encode($json), 'application/vnd.contentful.management.v1+json')
            ->withHeaders([
                'X-Contentful-Content-Type' => 'pseudonym',
                'Content-Type' => 'application/vnd.contentful.management.v1+json'
            ])
            ->withToken(config('app.cmaaccesstoken'))
            ->post(getCtUrl().'/entries');
        }else{
            $response = Http::withBody(json_encode($json), 'application/vnd.contentful.management.v1+json')
            ->withHeaders([
                'X-Contentful-Content-Type' => 'pseudonym',
                'Content-Type' => 'application/vnd.contentful.management.v1+json',
                'X-Contentful-Version' => intval($data->version)
            ])
            ->withToken(config('app.cmaaccesstoken'))
            ->put(getCtUrl().'/entries/'.$data->id);
        }
        //publish
        $response = Http::withHeaders([
                'X-Contentful-Version' => $response->json('sys.version')
            ])
            ->withToken(config('app.cmaaccesstoken'))
            ->put(getCtUrl().'/entries/'.$response->json('sys.id').'/published');
        if($data->defaultuser){
            generatePseudonym();
        }
        if(authuser()->id == $data->uid){
            $profile = getProfile(authuser()->id);
        }
        return $response->object();
    }

    public function deletepenname(Request $request){
        $data = json_decode($request->data);
        //find tags use
        $response = Http::withToken(config('app.cmaaccesstoken'))
        ->get(getCtUrl().'/entries?content_type=content&fields.pseudonym.sys.id='.$data->id.'&limit=1');
        $resObj = $response->object();
        if($resObj->total > 0)
        {
            return ['result'=>false];
        }
        //unpublish entry
        $response = Http::withHeaders([
            'X-Contentful-Version' => intval($data->version)
        ])
        ->withToken(config('app.cmaaccesstoken'))
        ->delete(getCtUrl().'/entries/'.$data->id.'/published');
        //delete entry
        $response = Http::withHeaders([
            'X-Contentful-Version' => $response->json('sys.version')
        ])
        ->withToken(config('app.cmaaccesstoken'))
        ->delete(getCtUrl().'/entries/'.$data->id);
        if($data->mid <> config('app.defaultimage')){
            //unpublish assets
            $response = Http::withHeaders([
                'X-Contentful-Version' => intval($data->mversion)
            ])
            ->withToken(config('app.cmaaccesstoken'))
            ->delete(getCtUrl().'/assets/'.$data->mid.'/published');
            //delete assets
            $response = Http::withHeaders([
                'X-Contentful-Version' => $response->json('sys.version')
            ])
            ->withToken(config('app.cmaaccesstoken'))
            ->delete(getCtUrl().'/assets/'.$data->mid);
        }
        if($data->defaultuser){
            generatePseudonym();
        }
        if(authuser()->id == $data->uid){
            $profile = getProfile(authuser()->id);
        }
        return ['result'=>true];
    }

    public function list(Request $request){
        $columns = array(
            0 => 'fields.firstname',
            1 => 'fields.lastname',
            2 => 'fields.email',
            3 => 'fields.role'
        );


        $limit = $request->input('length');
        $start = $request->input('start');


        $search = $request->input('search.value');

        $fieldorder = $columns[$request->input('order.0.column')];
        if($request->input('order.0.dir') == 'desc'){
            $fieldorder = '-'.$fieldorder;
        }

        $response = Http::withToken(config('app.cmaaccesstoken'))
        ->get(getCtUrl().'/entries',[
            'content_type'=>$this->contenttypeid,
            'query'=>$search,
            'order'=>$fieldorder,
            'limit'=>$limit,
            'skip'=>$start
        ]);
        $resObj = $response->object();


        $totalData = $resObj->total;

        $result = new \stdClass;
        $result->draw = intval($request->input('draw'));
        $result->recordsTotal = intval($totalData);
        $result->recordsFiltered = intval($totalData);
        $result->data = [];

        foreach($resObj->items as $item) {
            $data = new \stdClass;
            $data->id = $item->sys->id;
            $data->version = $item->sys->version;
            $data->email = $item->fields->email->{'en-US'};
            $data->firstname = $item->fields->firstname->{'en-US'};
            $data->lastname = $item->fields->lastname->{'en-US'};
            $data->role = $item->fields->role->{'en-US'};
            array_push($result->data,$data);
        }
        return $result;
    }

    function checkemail(Request $request)
    {
        $arrayquery = array("content_type"=>$this->contenttypeid);
        $arrayquery['fields.email'] = $request->email;
        $arrayquery['limit'] = 1;

        $response = Http::withToken(config('app.cmaaccesstoken'))
        ->get(getCtUrl().'/entries',$arrayquery);
        $user = $response->object();
        if($user->total == 0){
            return ['result'=>false];
        }
        return ['result'=>true];
    }
}
