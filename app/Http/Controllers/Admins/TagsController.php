<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Response;
use Redirect;
// use Session;

class TagsController extends Controller
{

    public function __construct()
    {
        $this->contenttypeid = 'tags';
    }

    function index(Request $request)
    {
        return view('admins.tags.index');
    }

    function new(Request $request)
    {
        $data = new \stdClass;
        $data->id = '';
        $data->version = 0;
        $data->name = '';
        return view('admins.tags.form',['data'=>$data]);
    }

    function create(Request $request)
    {
        $data = json_decode($request->data);
        $json = new \stdClass;
        $json->name = $data->name;
        $json->sys = new \stdClass;
        $json->sys->visibility = 'public';
        $json->sys->id = $data->id;
        $json->sys->type = 'Tag';
        if($data->id == ''){
            $response = Http::withBody(json_encode($json), 'application/vnd.contentful.management.v1+json')
            ->withHeaders([
                'Content-Type' => 'application/vnd.contentful.management.v1+json'
            ])
            ->withToken(config('app.cmaaccesstoken'))
            ->put(getCtUrl().'/tags/'.$data->id);
        }else{
            $response = Http::withBody(json_encode($json), 'application/vnd.contentful.management.v1+json')
            ->withHeaders([
                'Content-Type' => 'application/vnd.contentful.management.v1+json',
                'X-Contentful-Version' => intval($data->version)
            ])
            ->withToken(config('app.cmaaccesstoken'))
            ->put(getCtUrl().'/tags/'.$data->id);
        }
        $resObj = $response->object();
        generateTags();
        return $resObj;
    }

    function edit($id,Request $request)
    {
        $id = $request->id;
        $response = Http::withToken(config('app.cmaaccesstoken'))
        ->get(getCtUrl().'/tags/'.$id);

        $resObj = $response->object();
        $data = new \stdClass;
        $data->id = $resObj->sys->id;
        $data->version = $resObj->sys->version;
        $data->name = $resObj->name;
        return view('admins.tags.form',['data'=>$data]);
    }

    public function checkname(Request $request){
        $response = Http::withToken(config('app.cmaaccesstoken'))
            ->get(getCtUrl().'/tags',[
                'name' => $request->name,
                'limit' => 1
            ]);
        if($response->json('total') == 0){
            return ['result'=>true];
        }else{
            return ['result'=>false];
        }
    }

    public function checkid(Request $request){
        $response = Http::withToken(config('app.cmaaccesstoken'))
            ->get(getCtUrl().'/tags',[
                'sys.id' => $request->id,
                'limit' => 1
            ]);
        if($response->json('total') == 0){
            return ['result'=>true];
        }else{
            return ['result'=>false];
        }
    }

    function delete($id,Request $request)
    {
        $id = $request->id;
        //check entries use tags
        $response = Http::withToken(config('app.cmaaccesstoken'))
        ->get(getCtUrl().'/entries?metadata.tags.sys.id[all]='.$id);
        $resObj = $response->object();
        if($resObj->total > 0){
            return ["result"=>false];
        }
        //get tags data
        $response = Http::withToken(config('app.cmaaccesstoken'))
        ->get(getCtUrl().'/tags/'.$id);
        $resObj = $response->object();

        $response = Http::withHeaders([
            'X-Contentful-Version' => intval($resObj->sys->version)
        ])
        ->withToken(config('app.cmaaccesstoken'))
        ->delete(getCtUrl().'/tags/'.$id);
        return ["result"=>true];
    }

    public function list(Request $request){
        $columns = array(
            0 => 'name',
        );


        $limit = $request->input('length');
        $start = $request->input('start');


        $search = $request->input('search.value');

        $fieldorder = $columns[$request->input('order.0.column')];
        if($request->input('order.0.dir') == 'desc'){
            $fieldorder = '-'.$fieldorder;
        }

        $arrayquery = array("name[match]"=>$search);
        $arrayquery['order'] = $fieldorder;
        $arrayquery['limit'] = $limit;
        $arrayquery['skip'] = $start;

        $response = Http::withToken(config('app.cmaaccesstoken'))
        ->get(getCtUrl().'/tags',$arrayquery);

        $resObj = $response->object();

        $totalData = $resObj->total;

        $result = new \stdClass;
        $result->draw = intval($request->input('draw'));
        $result->recordsTotal = intval($totalData);
        $result->recordsFiltered = intval($totalData);
        $result->data = [];
        // $uPermission = authuser()->permission;
        foreach($resObj->items as $item) {
            $data = new \stdClass;
            $data->id = $item->sys->id;
            $data->version = $item->sys->version;
            $data->name = $item->name;
            array_push($result->data,$data);
        }
        return $result;
    }
}
