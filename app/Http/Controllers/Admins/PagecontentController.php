<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Response;
use Redirect;

class PagecontentController extends Controller
{
    public function __construct()
    {
        $this->contenttypeid = 'pagecontent';
    }

    function index(Request $request)
    {
        return view('admins.pagecontent.index');
    }

    function new(Request $request)
    {
        $data = new \stdClass;
        $data->id = '';
        $data->version = 0;
        $data->title = '';
        $data->slug = '';
        $data->content = '';
        $data->special = '';
        $data->active = true;
        $data->page = [];
        $data->session = [];
        $data->gallery = [];
        return view('admins.pagecontent.form',['data'=>$data]);
    }

    function create(Request $request)
    {
        $data = json_decode($request->data);
        $json = new \stdClass;
        $json->fields = new \stdClass;
        $json->fields->title = new \stdClass;
        $json->fields->title->{'en-US'} = $data->title;
        $json->fields->slug = new \stdClass;
        $json->fields->slug->{'en-US'} = $data->slug;
        $json->fields->active = new \stdClass;
        $json->fields->active->{'en-US'} = $data->active;
        $json->fields->content = new \stdClass;
        $json->fields->content->{'en-US'} = $data->content;
        $json->fields->special = new \stdClass;
        $json->fields->special->{'en-US'} = $data->special;
        $json->fields->gallery = new \stdClass;
        $json->fields->gallery->{'en-US'} = $data->gallery;
        $json->fields->page = new \stdClass;
        $json->fields->page->{'en-US'} = $data->page;
        $json->fields->session = new \stdClass;
        $json->fields->session->{'en-US'} = $data->session;
        // return $json;
        if($data->id == ''){
            $response = Http::withBody(json_encode($json), 'application/vnd.contentful.management.v1+json')
            ->withHeaders([
                'X-Contentful-Content-Type' => 'pagecontent',
                'Content-Type' => 'application/vnd.contentful.management.v1+json'
            ])
            ->withToken(config('app.cmaaccesstoken'))
            ->post(getCtUrl().'/entries');
        }else{
            $response = Http::withBody(json_encode($json), 'application/vnd.contentful.management.v1+json')
            ->withHeaders([
                'X-Contentful-Content-Type' => 'pagecontent',
                'Content-Type' => 'application/vnd.contentful.management.v1+json',
                'X-Contentful-Version' => intval($data->version)
            ])
            ->withToken(config('app.cmaaccesstoken'))
            ->put(getCtUrl().'/entries/'.$data->id);
        }
        $resObj = $response->object();

        //auto publish
        $response = Http::withHeaders([
            'X-Contentful-Version' => intval($resObj->sys->version)
        ])
        ->withToken(config('app.cmaaccesstoken'))
        ->put(getCtUrl().'/entries/'.$resObj->sys->id.'/published');
        $resObj = $response->object();
        return $resObj;
    }

    function edit($id,Request $request)
    {
        $id = $request->id;
        $response = Http::withToken(config('app.cmaaccesstoken'))
        ->get(getCtUrl().'/entries/'.$id);
        $resObj = $response->object();
        $data = new \stdClass;
        $data->id = $resObj->sys->id;
        $data->version = $resObj->sys->version;
        $data->title = $resObj->fields->title->{'en-US'};
        $data->slug = $resObj->fields->slug->{'en-US'};
        $data->content = $resObj->fields->content->{'en-US'};
        $data->special = $resObj->fields->special->{'en-US'};
        $data->page = $resObj->fields->page->{'en-US'};
        $data->session = $resObj->fields->session->{'en-US'};
        $data->gallery = $resObj->fields->gallery->{'en-US'};
        $data->active = $resObj->fields->active->{'en-US'};
        return view('admins.pagecontent.form',['data'=>$data]);
    }

    public function checkslug(Request $request){
        $response = Http::withToken(config('app.cmaaccesstoken'))
            ->get(getCtUrl().'/entries',[
                'content_type' => $this->contenttypeid,
                'fields.slug' => $request->slug,
                'limit' => 1
            ]);
        if($response->json('total') == 0){
            return ['result'=>true];
        }else{
            return ['result'=>false];
        }
    }

    public function published(Request $request){
        $response = Http::withHeaders([
            'X-Contentful-Version' => intval($request->version)
        ])
        ->withToken(config('app.cmaaccesstoken'))
        ->put(getCtUrl().'/entries/'.$request->id.'/published');
        if($response->status() == 200){
            return ['result'=>true,'data'=>$response->object()];
        }
        return ['result'=>false];
    }

    public function unpublished(Request $request){
        $response = Http::withHeaders([
            'X-Contentful-Version' => intval($request->version)
        ])
        ->withToken(config('app.cmaaccesstoken'))
        ->delete(getCtUrl().'/entries/'.$request->id.'/published');
        if($response->status() == 200){
            return ['result'=>true,'data'=>$response->object()];
        }
        return ['result'=>false];
    }

    public function archived(Request $request){
        $response = Http::withHeaders([
            'X-Contentful-Version' => intval($request->version)
        ])
        ->withToken(config('app.cmaaccesstoken'))
        ->put(getCtUrl().'/entries/'.$request->id.'/archived');
        if($response->status() == 200){
            return ['result'=>true,'data'=>$response->object()];
        }
        return ['result'=>false];
    }

    public function unarchived(Request $request){
        $response = Http::withHeaders([
            'X-Contentful-Version' => intval($request->version)
        ])
        ->withToken(config('app.cmaaccesstoken'))
        ->delete(getCtUrl().'/entries/'.$request->id.'/archived');
        if($response->status() == 200){
            return ['result'=>true,'data'=>$response->object()];
        }
        return ['result'=>false];
    }

    public function list(Request $request){
        $columns = array(
            0 => 'fields.title',
        );


        $limit = $request->input('length');
        $start = $request->input('start');


        $search = $request->input('search.value');

        $fieldorder = $columns[$request->input('order.0.column')];
        if($request->input('order.0.dir') == 'desc'){
            $fieldorder = '-'.$fieldorder;
        }

        $arrayquery = array("content_type"=>$this->contenttypeid);
        // if($request->status == 'all'){
        //     $arrayquery['sys.archivedAt[exists]'] = 'false';
        // }
        // if($request->status == 'draft'){
        //     $arrayquery['sys.publishedAt[exists]'] = 'false';
        //     $arrayquery['sys.archivedAt[exists]'] = 'false';
        // }
        // if($request->status == 'publish'){
        //     $arrayquery['sys.publishedAt[exists]'] = 'true';
        // }
        // if($request->status == 'archive'){
        //     $arrayquery['sys.archivedAt[exists]'] = 'true';
        // }
        $arrayquery['fields.title[match]'] = $search;
        $arrayquery['order'] = $fieldorder;
        $arrayquery['limit'] = $limit;
        $arrayquery['skip'] = $start;

        $response = Http::withToken(config('app.cmaaccesstoken'))
        ->get(getCtUrl().'/entries',$arrayquery);

        $resObj = $response->object();

        $totalData = $resObj->total;

        $result = new \stdClass;
        $result->draw = intval($request->input('draw'));
        $result->recordsTotal = intval($totalData);
        $result->recordsFiltered = intval($totalData);
        $result->data = [];
        $uPermission = authuser()->permission;
        foreach($resObj->items as $item) {
            $data = new \stdClass;
            $data->id = $item->sys->id;
            $data->version = $item->sys->version;
            $data->title = $item->fields->title->{'en-US'};
            $data->active = $item->fields->active->{'en-US'};
            $data->publishtool = false;
            $data->unpublishtool = false;
            $data->updatetool = true;
            $data->archivetool = true;
            $data->unarchivetool = false;
            $data->deletetool = false;
            $data->page = '';
            $data->session = '';
            foreach($item->fields->page->{'en-US'} as $page){
                if($data->page != ''){
                    $data->page = $data->page.',';
                }
                $data->page = $data->page.''.$page;
            }
            foreach($item->fields->session->{'en-US'} as $session){
                if($data->session != ''){
                    $data->session = $data->session.',';
                }
                $data->session = $data->session.''.$session;
            }
            array_push($result->data,$data);
        }
        // return authuser();
        return $result;
    }
}
