<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PositionController extends Controller
{
    public function __construct()
    {
        $this->contenttypeid = 'position';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admins.position.index');
    }
    public function new()
    {
        $skilldata = getSkill();
        $skills = $skilldata->skills;
        $interests = $skilldata->interests;
        $data = new \stdClass;
        $data->id = '';
        $data->version = 0;
        $data->title = '';
        $data->slug = '';
        $data->excerpt = '';
        $data->description = '';
        $data->ogimageid = '';
        $data->ogimage = '';
        $data->ogdescription = '';
        $data->keyword = '';
        $data->active = true;
        $data->skills = [];
        $data->interests = [];
        $data->thumbnailid = '';
        $data->thumbnail = '';
        return view('admins.position.form', [ 'data'=>$data,'skills'=>$skills,'interests'=>$interests]);
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

    public function create(Request $request)
    {
        $data = json_decode($request->data);
        $json = new \stdClass;
        $json->fields = new \stdClass;
        $json->fields->title = new \stdClass;
        $json->fields->title->{'en-US'} = $data->title;
        $json->fields->slug = new \stdClass;
        $json->fields->slug->{'en-US'} = $data->slug;
        $json->fields->excerpt = new \stdClass;
        $json->fields->excerpt->{'en-US'} = $data->excerpt;
        $json->fields->ogdescription = new \stdClass;
        $json->fields->ogdescription->{'en-US'} = $data->ogdescription;
        $json->fields->description = new \stdClass;
        $json->fields->description->{'en-US'} = $data->description;
        $json->fields->keyword = new \stdClass;
        $json->fields->keyword->{'en-US'} = $data->keyword;
        $json->fields->active = new \stdClass;
        $json->fields->active->{'en-US'} = $data->active;
        $json->fields->skills = new \stdClass;
        $json->fields->skills->{'en-US'} = $data->skills;
        $json->fields->interests = new \stdClass;
        $json->fields->interests->{'en-US'} = $data->interests;
        //thumbnail
        $json->fields->thumbnail = new \stdClass;
        $json->fields->thumbnail->{'en-US'} = new \stdClass;
        $json->fields->thumbnail->{'en-US'}->sys = new \stdClass;
        $json->fields->thumbnail->{'en-US'}->sys->type = "Link";
        $json->fields->thumbnail->{'en-US'}->sys->linkType = "Asset";
        $json->fields->thumbnail->{'en-US'}->sys->id = $data->thumbnail;
        $json->fields->ogimage = new \stdClass;
        $json->fields->ogimage->{'en-US'} = new \stdClass;
        $json->fields->ogimage->{'en-US'}->sys = new \stdClass;
        $json->fields->ogimage->{'en-US'}->sys->type = "Link";
        $json->fields->ogimage->{'en-US'}->sys->linkType = "Asset";
        $json->fields->ogimage->{'en-US'}->sys->id = $data->ogimage;
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
        return $resObj;
    }

    public function edit($id)
    {
        $skilldata = getSkill();
        $skills = $skilldata->skills;
        $interests = $skilldata->interests;


        $response = Http::withToken(config('app.cmaaccesstoken'))
        ->get(getCtUrl().'/entries/'.$id.'/references?include=10');
        $resObj = $response->object();
        $data = new \stdClass;
        $refsAsset = isset($resObj->includes->Asset)?$resObj->includes->Asset:[];
        $data->id = $resObj->items[0]->sys->id;
        $data->version = $resObj->items[0]->sys->version;
        $data->title = $resObj->items[0]->fields->title->{'en-US'};
        $data->slug = isset($resObj->items[0]->fields->slug->{'en-US'})?$resObj->items[0]->fields->slug->{'en-US'}:'';
        $data->excerpt = $resObj->items[0]->fields->excerpt->{'en-US'};
        $data->description = $resObj->items[0]->fields->description->{'en-US'};
        $data->ogdescription = isset($resObj->items[0]->fields->ogdescription->{'en-US'})?$resObj->items[0]->fields->ogdescription->{'en-US'}:'';
        $data->active = $resObj->items[0]->fields->active->{'en-US'};
        $data->keyword = isset($resObj->items[0]->fields->keyword->{'en-US'})?$resObj->items[0]->fields->keyword->{'en-US'}:'';
        $data->skills = $resObj->items[0]->fields->skills->{'en-US'};
        $data->interests = $resObj->items[0]->fields->interests->{'en-US'};
        //thumbnail
        $data->thumbnailid = '';
        $data->thumbnail = '';
        if(isset($resObj->items[0]->fields->thumbnail->{'en-US'}->sys))
        {
            foreach($refsAsset as $ref){
                if($ref->sys->id == $resObj->items[0]->fields->thumbnail->{'en-US'}->sys->id){
                    $data->thumbnailid = $resObj->items[0]->fields->thumbnail->{'en-US'}->sys->id;
                    $data->thumbnail = 'https:'.$ref->fields->file->{'en-US'}->url;
                    break;
                }
            }
        }
        //ogimage
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
        return view('admins.position.form', [ 'data'=>$data,'skills'=>$skills,'interests'=>$interests]);
    }

    public function delete($id, Request $request)
    {
        $position = Position::find($id)->delete();
        return ['result'=>true];
    }

    public function list(Request $request)
    {
        $columns = array(
            0 => 'fields.title',
            1 => 'fields.active',
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
            $data->active = $item->fields->active->{'en-US'};
            $data->archivetool = false;
            if(authuser()->role == 'admin'){
                $data->archivetool = true;
            }
            array_push($result->data,$data);
        }
        return $result;
    }
}
