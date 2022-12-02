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

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->contenttypeid = 'category';
    }

    function index(Request $request)
    {
        return view('admins.category.index');
    }

    function new(Request $request)
    {
        $categories = getCategory();
        $data = new \stdClass;
        $data->id = '';
        $data->version = 0;
        $data->title = '';
        $data->slug = '';
        $data->parent = 'main';
        $data->categoryorder = 1;
        //social
        $data->ogdescription = '';
        $data->keyword = '';
        $data->ogimage = '';
        $data->ogimageid = '';
        return view('admins.category.form',['data'=>$data,'categories'=>$categories]);
    }

    function create(Request $request)
    {
        $data = json_decode($request->data);
        $json = new \stdClass;
        $json->fields = new \stdClass;
        //parent
        if($data->parent <> 'main'){
            $categoryRef = [];
            $cateObj = new \stdClass;
            $cateObj->sys = new \stdClass;
            $cateObj->sys->type = "Link";
            $cateObj->sys->linkType = "Entry";
            $cateObj->sys->id = $data->parent;
            array_push($categoryRef,$cateObj);
            $json->fields->parent = new \stdClass;
            $json->fields->parent->{'en-US'} = $categoryRef;
        }

        $json->fields->title = new \stdClass;
        $json->fields->title->{'en-US'} = $data->title;
        $json->fields->slug = new \stdClass;
        $json->fields->slug->{'en-US'} = $data->slug;
        $json->fields->categoryorder = new \stdClass;
        $json->fields->categoryorder->{'en-US'} = intval($data->categoryorder);
        if(isset($data->ogimage)){
            //og image
            $json->fields->ogimage = new \stdClass;
            $json->fields->ogimage->{'en-US'} = new \stdClass;
            $json->fields->ogimage->{'en-US'}->sys = new \stdClass;
            $json->fields->ogimage->{'en-US'}->sys->type = "Link";
            $json->fields->ogimage->{'en-US'}->sys->linkType = "Asset";
            $json->fields->ogimage->{'en-US'}->sys->id = $data->ogimage;
        }
        //og description
        $json->fields->ogdescription = new \stdClass;
        $json->fields->ogdescription->{'en-US'} = $data->ogdescription;
        //keyword
        $json->fields->keyword = new \stdClass;
        $json->fields->keyword->{'en-US'} = $data->keyword;
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
        $resObj->status = 'publish';
        generateCategory();
        return $resObj;
    }

    function edit($id,Request $request)
    {
        $id = $request->id;
        $response = Http::withToken(config('app.cmaaccesstoken'))
        ->get(getCtUrl().'/entries/'.$id.'/references?include=10');
        $resObj = $response->object();
        $categories = getCategory($resObj->items[0]->sys->id);
        $data = new \stdClass;
        $refsAsset = isset($resObj->includes->Asset)?$resObj->includes->Asset:[];
        $data->id = $resObj->items[0]->sys->id;
        $data->version = $resObj->items[0]->sys->version;
        $data->title = $resObj->items[0]->fields->title->{'en-US'};
        $data->slug = isset($resObj->items[0]->fields->slug->{'en-US'})?$resObj->items[0]->fields->slug->{'en-US'}:'';
        $data->parent = 'main';
        if(isset($resObj->items[0]->fields->parent->{'en-US'}))
        {
            $data->parent = $resObj->items[0]->fields->parent->{'en-US'}[0]->sys->id;
        }
        $data->categoryorder = $resObj->items[0]->fields->categoryorder->{'en-US'};
        //social
        $data->ogdescription = isset($resObj->items[0]->fields->ogdescription->{'en-US'})?$resObj->items[0]->fields->ogdescription->{'en-US'}:'';
        $data->keyword = isset($resObj->items[0]->fields->keyword->{'en-US'})?$resObj->items[0]->fields->keyword->{'en-US'}:'';
        $data->ogimageid = '';
        $data->ogimage = '';
        if(isset($resObj->items[0]->fields->ogimage->{'en-US'}->sys))
        {
            foreach($refsAsset as $ref){
                if($ref->sys->id == $resObj->items[0]->fields->ogimage->{'en-US'}->sys->id){
                    $data->ogimageid = $resObj->items[0]->fields->ogimage->{'en-US'}->sys->id;
                    $data->ogimage = 'https:'.$ref->fields->file->{'en-US'}->url;
                    break;
                }
            }
        }
        $data->status = 'draft';
        if(isset($resObj->items[0]->sys->publishedAt)){
            $data->status = 'publish';
        }
        if(isset($resObj->items[0]->sys->archivedAt)){
            $data->status = 'archive';
        }
        return view('admins.category.form',['data'=>$data,'categories'=>$categories]);
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

    public function archived(Request $request){
        //check category
        $arrayquery = array("content_type"=>$this->contenttypeid);
        $arrayquery['fields.parent.sys.id'] = $request->id;
        $arrayquery['limit'] = 1;
        $countresponse = Http::withToken(config('app.cmaaccesstoken'))
        ->get(getCtUrl().'/entries',$arrayquery);
        if($countresponse->json('total') > 0){
            return ['result'=>false,'message'=>'Have Parent category can not archive.'];
        }
        //check content
        $arrayquery = array("content_type"=>"content");
        $arrayquery['fields.category.sys.id'] = $request->id;
        $arrayquery['limit'] = 1;
        $countresponse = Http::withToken(config('app.cmaaccesstoken'))
        ->get(getCtUrl().'/entries',$arrayquery);
        if($countresponse->json('total') > 0){
            return ['result'=>false,'message'=>'Have Content in this category can not archive.'];
        }
        //check user
        $arrayquery = array("content_type"=>"user");
        $arrayquery['fields.permission.sys.id'] = $request->id;
        $arrayquery['limit'] = 1;
        $countresponse = Http::withToken(config('app.cmaaccesstoken'))
        ->get(getCtUrl().'/entries',$arrayquery);
        if($countresponse->json('total') > 0){
            return ['result'=>false,'message'=>'Have User permission in this category can not archive.'];
        }
        //get data
        $responsedata = Http::withToken(config('app.cmaaccesstoken'))
        ->get(getCtUrl().'/entries/'.$request->id);
        $data = $responsedata->object();
        //unpublish
        $delresponse = Http::withHeaders([
            'X-Contentful-Version' => intval($data->sys->version)
        ])
        ->withToken(config('app.cmaaccesstoken'))
        ->delete(getCtUrl().'/entries/'.$request->id.'/published');
        //archive
        $response = Http::withHeaders([
            'X-Contentful-Version' => intval($delresponse->json('sys.version'))
        ])
        ->withToken(config('app.cmaaccesstoken'))
        ->put(getCtUrl().'/entries/'.$request->id.'/archived');
        if($response->status() == 200){
            generateCategory();
            return ['result'=>true,'data'=>$response->object()];
        }
        return ['result'=>false,'message'=>'Can not archived.'];
    }

    public function list(Request $request){
        $columns = array(
            0 => 'fields.title',
            1 => 'fields.categoryorder',
        );


        $limit = $request->input('length');
        $start = $request->input('start');


        $search = $request->input('search.value');

        $fieldorder = $columns[$request->input('order.0.column')];
        if($request->input('order.0.dir') == 'desc'){
            $fieldorder = '-'.$fieldorder;
        }

        $arrayquery = array("content_type"=>$this->contenttypeid);
        $arrayquery['fields.title[match]'] = $search;
        $arrayquery['sys.archivedAt[exists]'] = 'false';
        if($request->main == 'true'){
            $arrayquery['fields.parent[exists]'] = 'false';
        }else{
            $arrayquery['fields.parent[exists]'] = 'true';
            if($request->id <> 'main'){
                $arrayquery['fields.parent.sys.id'] = $request->id;
            }

        }
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
        // $uPermission = authuser()->permission;
        foreach($resObj->items as $item) {
            $data = new \stdClass;
            $data->id = $item->sys->id;
            $data->version = $item->sys->version;
            $data->title = $item->fields->title->{'en-US'};
            $data->categoryorder = $item->fields->categoryorder->{'en-US'};
            $data->archivetool = false;
            if(authuser()->role == 'admin'){
                $data->archivetool = true;
            }
            array_push($result->data,$data);
        }
        return $result;
    }
}
