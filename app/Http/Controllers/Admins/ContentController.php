<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
// use Auth;


class ContentController extends Controller
{
    public function __construct()
    {
        $this->contenttypeid = 'content';
    }

    public function index()
    {
        return view('admins.content.index');
    }

    public function new()
    {
        $categories = getCategory();
        $data = new \stdClass;
        $data->id = '';
        $data->version = 0;
        $data->title = '';
        $data->slug = '';
        $data->excerpt = '';
        $data->owner = authuser()->email;
        $data->status = 'draft';
        $data->thumbnailid = '';
        $data->thumbnail = '';
        $data->heroimageid = '';
        $data->heroimage = '';
        $data->categories = [];
        //social
        $data->ogtitle = '';
        $data->ogdescription = '';
        $data->keyword = '';
        $data->ogimage = '';
        $data->ogimageid = '';
        $components = [];
        $body = new \stdClass;
        $body->component = 'content';
        $body->title = 'Content';
        $body->content = '';
        $body->display = true;
        array_push($components,$body);
        $body = new \stdClass;
        $body->component = 'single-image';
        $body->title = 'Single Image';
        $body->image = '';
        $body->imagetitle = '';
        $body->display = true;
        array_push($components,$body);
        $reference = [];
        $data->tags = [];
        return view('admins.content.form',['data'=>$data,'tags'=>getTags(),'categories'=>$categories,'components'=>$components,'publiccredits'=>getPseudonym('',false,true),'pseudonyms'=>authuser()->pseudonyms,'reference'=>$reference]);
    }

    public function edit($id)
    {
        $response = Http::withToken(config('app.cmaaccesstoken'))
        ->get(getCtUrl().'/entries/'.$id.'/references?include=10');
        $resObj = $response->object();
        if(authuser()->role == 'author'){
            if($resObj->items[0]->fields->owner->{'en-US'} != authuser()->username){
                return redirect()->route('contentindex');
            }
        }
        $tags = getTags();
        $categories = getCategory();
        // $categories = authuser()->permission;
        $data = new \stdClass;
        $refsAsset = $resObj->includes->Asset;
        $refsEntry = $resObj->includes->Entry;
        $data->id = $resObj->items[0]->sys->id;
        $data->version = $resObj->items[0]->sys->version;
        $data->title = $resObj->items[0]->fields->title->{'en-US'};
        $data->slug = isset($resObj->items[0]->fields->slug->{'en-US'})?$resObj->items[0]->fields->slug->{'en-US'}:'';
        $data->excerpt = $resObj->items[0]->fields->excerpt->{'en-US'};
        $data->owner = $resObj->items[0]->fields->owner->{'en-US'};
        $data->categories = [];
        //category
        if(isset($resObj->items[0]->fields->category->{'en-US'})){
            foreach($resObj->items[0]->fields->category->{'en-US'} as $catecontent){
                foreach($categories as $ref){
                    if($ref->id == $catecontent->sys->id){
                        $cateObj = new \stdClass;
                        $cateObj->id = $ref->id;
                        $cateObj->name = $ref->name;
                        array_push($data->categories,$cateObj);
                        break;
                    }
                }
            }
        }
        $data->tags = [];
        //category
        if(isset($resObj->items[0]->metadata->tags)){
            foreach($resObj->items[0]->metadata->tags as $tagcontent){
                foreach($tags as $tag){
                    if($tag->id == $tagcontent->sys->id){
                        $tagObj = new \stdClass;
                        $tagObj->id = $tag->id;
                        $tagObj->name = $tag->name;
                        array_push($data->tags,$tagObj);
                        break;
                    }
                }
            }
        }
        $data->pseudonyms = [];
        //pseudonyms
        $pseudonyms = authuser()->pseudonyms;
        $allpseudonyms = getPseudonym('',false,true);
        if(isset($resObj->items[0]->fields->pseudonym->{'en-US'})){
            foreach($resObj->items[0]->fields->pseudonym->{'en-US'} as $pseudonymcontent){
                foreach($allpseudonyms as $item){
                    if($item->id == $pseudonymcontent->sys->id)
                    {
                        $pseudonymObj = new \stdClass;
                        $pseudonymObj->id = $item->id;
                        $pseudonymObj->name = $item->name;
                        array_push($data->pseudonyms,$pseudonymObj);
                        break;
                    }
                }
                foreach($pseudonyms as $item){
                    if($item->id == $pseudonymcontent->sys->id)
                    {
                        $pseudonymObj = new \stdClass;
                        $pseudonymObj->id = $item->id;
                        $pseudonymObj->name = $item->name;
                        array_push($data->pseudonyms,$pseudonymObj);
                        break;
                    }
                }
            }
        }
        //thumbnail
        $data->thumbnailid = '';
        $data->thumbnail = '';
        if(isset($resObj->items[0]->fields->thumbnail))
        {
            foreach($refsAsset as $ref){
                if($ref->sys->id == $resObj->items[0]->fields->thumbnail->{'en-US'}->sys->id){
                    $data->thumbnailid = $resObj->items[0]->fields->thumbnail->{'en-US'}->sys->id;
                    $data->thumbnail = 'https:'.$ref->fields->file->{'en-US'}->url;
                    break;
                }
            }
        }
        //hero
        $data->heroimage = '';
        $data->heroimageid = '';
        foreach($refsAsset as $ref){
            if($ref->sys->id == $resObj->items[0]->fields->thumbnail->{'en-US'}->sys->id){
                $data->heroimageid = $resObj->items[0]->fields->thumbnail->{'en-US'}->sys->id;
                $data->heroimage = 'https:'.$ref->fields->file->{'en-US'}->url;
                break;
            }
        }
        //social
        $data->ogtitle = isset($resObj->items[0]->fields->ogtitle->{'en-US'})?$resObj->items[0]->fields->ogtitle->{'en-US'}:'';
        $data->ogdescription = $resObj->items[0]->fields->ogdescription->{'en-US'};
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
        return view('admins.content.form',['data'=>$data,'tags'=>$tags,'categories'=>$categories,'components'=>$resObj->items[0]->fields->content->{'en-US'},'publiccredits'=>$allpseudonyms,'pseudonyms'=>$pseudonyms,'reference'=>isset($resObj->items[0]->fields->reference->{'en-US'})?$resObj->items[0]->fields->reference->{'en-US'}:[]]);
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

    function create(Request $request)
    {
        $data = json_decode($request->data);
        $categories = getCategory();
        $categoryRef = [];
        $usecategory = [];
        foreach($data->category as $cateItem){
            foreach($categories as $categoryMaster){
                if($cateItem == $categoryMaster->id){
                    foreach($categoryMaster->category as $cateMasterId){
                        array_push($usecategory,$cateMasterId);
                    }
                }
            }
        }
        foreach(array_unique($usecategory) as $useid){
            $cateObj = new \stdClass;
            $cateObj->sys = new \stdClass;
            $cateObj->sys->type = "Link";
            $cateObj->sys->linkType = "Entry";
            $cateObj->sys->id = $useid;
            array_push($categoryRef,$cateObj);
        }
        $json = new \stdClass;
        $json->fields = new \stdClass;
        //category
        $json->fields->category = new \stdClass;
        $json->fields->category->{'en-US'} = $categoryRef;
        //tag
        $json->metadata = new \stdClass;
        $json->metadata->tags = [];
        foreach($data->tags as $tag){
            $ctag = new \stdClass;
            $ctag->sys = new \stdClass;
            $ctag->sys->type = "Link";
            $ctag->sys->linkType = "Tag";
            $ctag->sys->id = $tag;
            array_push($json->metadata->tags,$ctag);
        }
        //pseudonym
        $json->fields->pseudonym = new \stdClass;
        $json->fields->pseudonym->{'en-US'} = [];
        foreach($data->pseudonym as $pseudonymItem){
            $pseudonymObj = new \stdClass;
            $pseudonymObj->sys = new \stdClass;
            $pseudonymObj->sys->type = "Link";
            $pseudonymObj->sys->linkType = "Entry";
            $pseudonymObj->sys->id = $pseudonymItem->id;
            array_push($json->fields->pseudonym->{'en-US'},$pseudonymObj);
        }
        //thumbnail
        $json->fields->thumbnail = new \stdClass;
        $json->fields->thumbnail->{'en-US'} = new \stdClass;
        $json->fields->thumbnail->{'en-US'}->sys = new \stdClass;
        $json->fields->thumbnail->{'en-US'}->sys->type = "Link";
        $json->fields->thumbnail->{'en-US'}->sys->linkType = "Asset";
        $json->fields->thumbnail->{'en-US'}->sys->id = $data->thumbnail;
        $json->fields->title = new \stdClass;
        $json->fields->title->{'en-US'} = $data->title;
        $json->fields->slug = new \stdClass;
        $json->fields->slug->{'en-US'} = $data->slug;
        $json->fields->excerpt = new \stdClass;
        $json->fields->excerpt->{'en-US'} = $data->excerpt;
        $json->fields->heroimage = new \stdClass;
        $json->fields->heroimage->{'en-US'} = new \stdClass;
        $json->fields->heroimage->{'en-US'}->sys = new \stdClass;
        $json->fields->heroimage->{'en-US'}->sys->type = "Link";
        $json->fields->heroimage->{'en-US'}->sys->linkType = "Asset";
        $json->fields->heroimage->{'en-US'}->sys->id = $data->heroimage;
        //og image
        $json->fields->ogimage = new \stdClass;
        $json->fields->ogimage->{'en-US'} = new \stdClass;
        $json->fields->ogimage->{'en-US'}->sys = new \stdClass;
        $json->fields->ogimage->{'en-US'}->sys->type = "Link";
        $json->fields->ogimage->{'en-US'}->sys->linkType = "Asset";
        $json->fields->ogimage->{'en-US'}->sys->id = $data->ogimage;
        //og title
        $json->fields->ogtitle = new \stdClass;
        $json->fields->ogtitle->{'en-US'} = $data->ogtitle;
        //og description
        $json->fields->ogdescription = new \stdClass;
        $json->fields->ogdescription->{'en-US'} = $data->ogdescription;
        //keyword
        $json->fields->keyword = new \stdClass;
        $json->fields->keyword->{'en-US'} = $data->keyword;
        // content
        $json->fields->content = new \stdClass;
        $json->fields->content->{'en-US'} = $data->content;
        // reference
        $json->fields->reference = new \stdClass;
        $json->fields->reference->{'en-US'} = $data->reference;
        $json->fields->owner = new \stdClass;
        $json->fields->owner->{'en-US'} = $data->owner;
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
        $resObj = $response->object();
        $resObj->status = 'draft';
        if(isset($resObj->sys->publishedAt)){
            //if publish set re publish
            $response = Http::withHeaders([
                'X-Contentful-Version' => intval($resObj->sys->version)
            ])
            ->withToken(config('app.cmaaccesstoken'))
            ->put(getCtUrl().'/entries/'.$resObj->sys->id.'/published');
            $resObj = $response->object();
            $resObj->status = 'publish';
            return $resObj;
        }

        if(isset($resObj->sys->archivedAt)){
            $resObj->status = 'archive';
        }
        return $resObj;
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
            $data->publishtool = false;
            $data->unpublishtool = false;
            $data->updatetool = false;
            $data->archivetool = false;
            $data->unarchivetool = false;
            $data->deletetool = false;
            if(authuser()->role == 'author'){
                if($item->fields->owner->{'en-US'} == authuser()->email){
                    if($data->status <> 'publish'){
                        $data->updatetool = true;
                    }
                }
            }else{
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
            array_push($result->data,$data);
        }
        // return authuser();
        return $result;
    }
}
