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

class PagecontentController extends Controller
{

    function index(Request $request)
    {
        return view('pagecontent.index');
    }

    function new(Request $request)
    {
        $data = new \stdClass;
        $data->id = '';
        $data->version = 0;
        $data->title = '';
        $data->slug = '';
        $data->content = '';
        $data->active = true;
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
        ->get(getCtUrl().'/entries/'.$id.'/references?include=10');
        $resObj = $response->object();
        $data = new \stdClass;
        $data->id = $resObj->items[0]->sys->id;
        $data->version = $resObj->items[0]->sys->version;
        $data->title = $resObj->items[0]->fields->title->{'en-US'};
        $data->slug = $resObj->items[0]->fields->slug->{'en-US'};
        $data->content = $resObj->items[0]->fields->content->{'en-US'};
        $data->active = $resObj->items[0]->fields->active->{'en-US'};
        return view('admins.pagecontent.form',['data'=>$data]);
    }

    function preview(Request $request)
    {
        $id = $request->id;
        $response = Http::withToken(config('app.cmaaccesstoken'))
        ->get(getCtUrl().'/entries/'.$id.'/references?include=10');
        $resObj = $response->object();
        $data = new \stdClass;
        $refs = $resObj->includes->Asset;
        $refsEntry = isset($resObj->includes->Entry)?$resObj->includes->Entry:[];
        $data->title = $resObj->items[0]->fields->title->{'en-US'};
        $data->excerpt = $resObj->items[0]->fields->excerpt->{'en-US'};
        $data->entrybullet = isset($resObj->items[0]->fields->entrybullet->{'en-US'})?$resObj->items[0]->fields->entrybullet->{'en-US'}:[];
        $data->type = $resObj->items[0]->fields->contenttype->{'en-US'};
        //thumbnail
        foreach($refs as $ref){
            if($ref->sys->id == $resObj->items[0]->fields->thumbnail->{'en-US'}->sys->id){
                $data->thumbnail = 'https:'.$ref->fields->file->{'en-US'}->url;
                break;
            }
        }
        //hero
        $data->herovideo = isset($resObj->items[0]->fields->herovideo->{'en-US'})?$resObj->items[0]->fields->herovideo->{'en-US'}:'';
        $data->heroslide = isset($resObj->items[0]->fields->heroslide->{'en-US'})?$resObj->items[0]->fields->heroslide->{'en-US'}:[];
        $data->heropodcast = isset($resObj->items[0]->fields->heropodcast->{'en-US'})?$resObj->items[0]->fields->heropodcast->{'en-US'}:'';
        $data->podcast = isset($resObj->items[0]->fields->podcast->{'en-US'})?$resObj->items[0]->fields->podcast->{'en-US'}:'';
        $data->podcastchannel = isset($resObj->items[0]->fields->podcastchannel->{'en-US'})?$resObj->items[0]->fields->podcastchannel->{'en-US'}:[];
        $data->heroimage = '';
        if($resObj->items[0]->fields->contenttype->{'en-US'} == 'hero'){
            foreach($refs as $ref){
                if($ref->sys->id == $resObj->items[0]->fields->thumbnail->{'en-US'}->sys->id){
                    $data->heroimage = 'https:'.$ref->fields->file->{'en-US'}->url;
                    break;
                }
            }
        }
        //social
        $data->ogdescription = $resObj->items[0]->fields->ogdescription->{'en-US'};
        $data->ogimage = '';
        if(isset($resObj->items[0]->fields->ogimage->{'en-US'}->sys))
        {
            foreach($refs as $ref){
                if($ref->sys->id == $resObj->items[0]->fields->ogimage->{'en-US'}->sys->id){
                    $data->ogimage = 'https:'.$ref->fields->file->{'en-US'}->url;
                    break;
                }
            }
        }
        $data->spotlightimageid = '';
        $data->spotlightimage = '';
        if(isset($resObj->items[0]->fields->spotlightimage->{'en-US'}->sys))
        {
            foreach($refs as $ref){
                if($ref->sys->id == $resObj->items[0]->fields->spotlightimage->{'en-US'}->sys->id){
                    $data->spotlightimage = 'https:'.$ref->fields->file->{'en-US'}->url;
                    break;
                }
            }
        }
        $data->contents = $resObj->items[0]->fields->content->{'en-US'};
        $data->reference = $resObj->items[0]->fields->reference->{'en-US'};
        //penname
        $data->pseudonym = [];
        if(isset($resObj->items[0]->fields->pseudonym->{'en-US'}))
        {
            foreach($resObj->items[0]->fields->pseudonym->{'en-US'} as $pseudonym){
                foreach($refsEntry as $entry){
                    if($entry->sys->id == $pseudonym->sys->id){
                        $pseudonymObj = new \stdClass;
                        $pseudonymObj->id = $pseudonym->sys->id;
                        $pseudonymObj->name = $entry->fields->name->{'en-US'};
                        //image
                        foreach($refs as $ref){
                            if($ref->sys->id == $entry->fields->profileimage->{'en-US'}->sys->id){
                                $pseudonymObj->profileimage = 'https:'.$ref->fields->file->{'en-US'}->url;
                                break;
                            }
                        }
                        array_push($data->pseudonym,$pseudonymObj);
                        break;
                    }
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
        return view('content.preview',['data'=>$data]);
    }

    public function checkslug(Request $request){
        $response = Http::withToken(config('app.cmaaccesstoken'))
            ->get(getCtUrl().'/entries',[
                'content_type' => 'pagecontent',
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

    public function gallery($id)
    {
        return view('admins.content.gallery', [ 'content' => Content::find($id)]);
    }

    public function updategallery($id,Request $request){
        $content = Content::find($id);
        $galleryArray = array();
        if($request->image)
        {
            foreach ($request->image as $key=>$value)
            {
                $imageObject = new \stdClass;
                $imageObject->image = $request->image[$key];
                array_push($galleryArray,$imageObject);
            }
        }
        $content->gallery = json_encode($galleryArray);
        $content->save();
        return redirect()->route('contentindex')->with('success', 'Update gallery success!');
    }

    public function list(Request $request){
        $columns = array(
            0 => 'fields.title',
            1 => 'sys.createdAt',
        );


        $limit = $request->input('length');
        $start = $request->input('start');


        $search = $request->input('search.value');

        $fieldorder = $columns[$request->input('order.0.column')];
        if($request->input('order.0.dir') == 'desc'){
            $fieldorder = '-'.$fieldorder;
        }

        $arrayquery = array("content_type"=>"content");
        if($request->status == 'all'){
            $arrayquery['sys.archivedAt[exists]'] = 'false';
        }
        if($request->status == 'draft'){
            $arrayquery['sys.publishedAt[exists]'] = 'false';
            $arrayquery['sys.archivedAt[exists]'] = 'false';
        }
        if($request->status == 'publish'){
            $arrayquery['sys.publishedAt[exists]'] = 'true';
        }
        if($request->status == 'archive'){
            $arrayquery['sys.archivedAt[exists]'] = 'true';
        }
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
            $data->owner = $item->fields->owner->{'en-US'};
            $data->type = isset($item->fields->contenttype)?$item->fields->contenttype->{'en-US'}:'hero';
            $createAt = explode(".",$item->sys->createdAt);
            $dt = date_create_from_format('Y-m-d\TH:i:s', $createAt[0]);
            date_add($dt,date_interval_create_from_date_string("7 hours"));
            $data->createat = date_format($dt,"d / m / Y H:i");
            //status
            $data->status = 'draft';
            if(isset($item->sys->publishedAt)){
                $data->status = 'change';
                if($item->sys->publishedAt == $item->sys->updatedAt){
                    $data->status = 'publish';
                }
            }else{
                if(isset($item->sys->archivedAt)){
                    $data->status = 'archive';
                }
            }
            $categorypermission = false;
            if(isset($item->fields->category->{'en-US'})){
                foreach($item->fields->category->{'en-US'} as $uCate){
                    foreach($uPermission as $uPer){
                        if($uCate->sys->id == $uPer->id){
                            $categorypermission = true;
                            break;
                        }
                    }
                    if($categorypermission){
                        break;
                    }
                }
            }
            $data->publishtool = false;
            $data->unpublishtool = false;
            $data->updatetool = false;
            $data->archivetool = false;
            $data->unarchivetool = false;
            $data->deletetool = false;
            if(authuser()->role == 'author'){
                if($item->fields->owner->{'en-US'} == authuser()->username){
                    if($data->status <> 'publish'){
                        $data->updatetool = true;
                    }
                }
            }else{
                //check permission
                if($categorypermission){
                    $data->updatetool = true;
                    switch($data->status){
                        case 'publish':
                            $data->unpublishtool = true;
                            break;
                        case 'draft':
                            $data->publishtool = true;
                            $data->archivetool = true;
                            break;
                        case 'archive':
                            $data->deletetool = true;
                            $data->unarchivetool = true;
                            break;
                    }
                }
            }
            array_push($result->data,$data);
        }
        // return authuser();
        return $result;
    }

    public function browsecontent(Request $request){
        return view('content.browsecontent');
    }

    public function loadcontent(Request $request){
        $data = [];
        $limit = 16;
        $skip = (intval($request->page) - 1) * $limit;
        $query = 'query contentCollectionQuery { contentCollection(limit:'.$limit.' skip:'.$skip.' where:{ title_contains : "'.$request->search.'" }) { total items { sys { id } title thumbnail { url } } } }';
        $response = Http::withBody(json_encode([
            'query' => $query,
        ]),'')
            ->withToken(config('app.cdaaccesstoken'))
            ->post(getCtGraphqlUrl());
        $resObj = $response->object();
        $result = new \stdClass;
        $result->page = ceil($resObj->data->contentCollection->total / $limit);
        $result->items = $resObj->data->contentCollection->items;
        return $result;
    }
}
