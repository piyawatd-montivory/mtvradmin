<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Response;

class ImageController extends Controller
{

    public function __construct()
    {

    }

    function index(Request $request)
    {
        return view('admins.image.index');
    }

    function new(Request $request)
    {
        return view('admins.image.new');
    }

    function edit($id,Request $request)
    {
        $response = Http::withToken(config('app.cmaaccesstoken'))
        ->get(getCtUrl().'/assets/'.$id);
        // return $response->object();
        return view('admins.image.edit',["data"=>$response->object()]);
    }

    function ck(Request $request)
    {
        return view('admins.image.ck',['CKEditorFuncNum' => $request->input('CKEditorFuncNum')]);
    }

    function browseimage(Request $request)
    {
        return view('admins.image.browseimage',['type'=>$request->type]);
    }

    function loadimage(Request $request){
        $limit = 12;
        $skip = (intval($request->page) - 1) * $limit;
        $arrayquery = array("mimetype_group"=>"image");
        $arrayquery['fields.title[match]'] = isset($request->search)?$request->search:'';
        $arrayquery['sys.publishedAt[exists]'] = 'true';
        $arrayquery['skip'] = $skip;
        $arrayquery['limit'] = $limit;
        $arrayquery['order'] = '-sys.createdAt';
        $arrayquery['metadata.tags.sys.id[nin]'] = 'profileimage,defaultimage';
        $response = Http::withToken(config('app.cmaaccesstoken'))
        ->get(getCtUrl().'/assets',$arrayquery);
        $resObj = $response->object();
        $result = new \stdClass;
        $result->page = ceil($resObj->total / 9);
        $result->items = [];
        foreach($resObj->items as $item){
            $image = new \stdClass;
            $image->id = $item->sys->id;
            $image->version = $item->sys->version;
            $image->title = $item->fields->title->{'en-US'};
            $image->description = isset($item->fields->description) ? $item->fields->description->{'en-US'} : '';
            $image->file = $item->fields->file->{'en-US'}->url;
            array_push($result->items,$image);
        }
        return $result;
    }

    function upload(Request $request) {
        $uploadedFile = $request->file('fileupload');
        $filenameElements = explode('.', $uploadedFile->getClientOriginalName());
        $extension = array_pop($filenameElements);
        $filename = implode('.', $filenameElements);
        // upload
        $fp = fopen($uploadedFile, 'r');
        $ReadBinary = fread($fp,filesize($uploadedFile ));
        fclose($fp);
        $FileData = addslashes($ReadBinary);
        $response = Http::withBody(
            $ReadBinary, 'application/octet-stream'
        )
        ->withHeaders(['Content-Type' => 'application/octet-stream'])
        ->withToken(config('app.cmaaccesstoken'))
        ->post('https://'.config('app.uploadurl').'/spaces/'.config('app.spaceid').'/uploads');
        $uploadRes = $response->object();
        // Create Assets
        $assets = new \stdClass;
        $assets->fields = new \stdClass;
        $assets->fields->title = new \stdClass;
        $assets->fields->title->{'en-US'} = $request->title;
        $assets->fields->description = new \stdClass;
        $assets->fields->description->{'en-US'} = $request->description;
        $assets->fields->file = new \stdClass;
        $assets->fields->file->{'en-US'} = new \stdClass;
        if ($extension == 'png') {
            $assets->fields->file->{'en-US'}->contentType = "image/png";
        }else if($extension == 'jpg'){
            $assets->fields->file->{'en-US'}->contentType = "image/jpg";
        }else{
            $assets->fields->file->{'en-US'}->contentType = "image/jpeg";
        }
        $assets->fields->file->{'en-US'}->fileName = $filename;
        $assets->fields->file->{'en-US'}->uploadFrom = new \stdClass;
        $assets->fields->file->{'en-US'}->uploadFrom->sys = new \stdClass;
        $assets->fields->file->{'en-US'}->uploadFrom->sys->type = 'Link';
        $assets->fields->file->{'en-US'}->uploadFrom->sys->linkType = 'Upload';
        $assets->fields->file->{'en-US'}->uploadFrom->sys->id = $uploadRes->sys->id;
        $assetsId = '';
        $assetsVersion = 0;
        if($request->mid)
        {
            $assetsId = $request->mid;
            $assetsVersion = intval($request->mversion);
            $response = Http::withBody(json_encode($assets), 'application/vnd.contentful.management.v1+json')
            ->withHeaders([
                'Content-Type' => 'application/vnd.contentful.management.v1+json',
                'X-Contentful-Version' => $assetsVersion
            ])
            ->withToken(config('app.cmaaccesstoken'))
            ->put(getCtUrl().'/assets/'.$assetsId);
        }else{
            $response = Http::withBody(json_encode($assets), 'application/vnd.contentful.management.v1+json')
            ->withToken(config('app.cmaaccesstoken'))
            ->post(getCtUrl().'/assets');
            $assetsId = $response->json('sys.id');
            $assetsVersion = intval($response->json('sys.version'));
        }
        // Process Asset
        $response = Http::withHeaders([
            'X-Contentful-Version' => $assetsVersion
        ])
        ->withToken(config('app.cmaaccesstoken'))
        ->put(getCtUrl().'/assets/'.$assetsId.'/files/en-US/process');
        if($response->status() <> 204){
            return false;
        }
        $response = Http::withToken(config('app.cmaaccesstoken'))
        ->get(getCtUrl().'/assets/'.$assetsId);
        // // Published Assets
        // $response = Http::withHeaders([
        //     'X-Contentful-Version' => $response->json('sys.version')
        // ])
        // ->withToken(config('app.cmaaccesstoken'))
        // ->put(getCtUrl().'/assets/'.$assetsId.'/published');
        $resObj = $response->object();
        $result = new \stdClass;
        $result->id = $resObj->sys->id;
        $result->version = $resObj->sys->version;
        $result->title = $resObj->fields->title->{'en-US'};
        $result->description = $resObj->fields->description->{'en-US'};
        $result->url = 'https:'.$resObj->fields->file->{'en-US'}->url;
        return $result;
    }

    function update(Request $request)
    {
        $data = json_decode($request->data);
        // Create Assets
        $assets = new \stdClass;
        $assets->fields = new \stdClass;
        $assets->fields->title = new \stdClass;
        $assets->fields->title->{'en-US'} = $data->title;
        $assets->fields->description = new \stdClass;
        $assets->fields->description->{'en-US'} = $data->description;
        $assets->fields->file = new \stdClass;
        $assets->fields->file->{'en-US'} = new \stdClass;
        $assets->fields->file->{'en-US'}->contentType = $data->contentType;
        $assets->fields->file->{'en-US'}->fileName = $data->filename;
        $assets->fields->file->{'en-US'}->url = $data->url;
        $version = intval($data->version);
        //update assets
        $response = Http::withBody(json_encode($assets), 'application/vnd.contentful.management.v1+json')
        ->withHeaders([
            'Content-Type' => 'application/vnd.contentful.management.v1+json',
            'X-Contentful-Version' => $version
        ])
        ->withToken(config('app.cmaaccesstoken'))
        ->put(getCtUrl().'/assets/'.$data->id);;
        return ['result'=>true];
    }

    function updatenewimage(Request $request) {
        $uploadedFile = $request->file('fileupload');
        $filenameElements = explode('.', $uploadedFile->getClientOriginalName());
        $extension = array_pop($filenameElements);
        $filename = implode('.', $filenameElements);
        // upload
        $fp = fopen($uploadedFile, 'r');
        $ReadBinary = fread($fp,filesize($uploadedFile ));
        fclose($fp);
        $FileData = addslashes($ReadBinary);
        //upload image
        $response = Http::withBody(
            $ReadBinary, 'application/octet-stream'
        )
        ->withHeaders(['Content-Type' => 'application/octet-stream'])
        ->withToken(config('app.cmaaccesstoken'))
        ->post('https://'.config('app.uploadurl').'/spaces/'.config('app.spaceid').'/uploads');
        $uploadRes = $response->object();
        // Create Assets
        $assets = new \stdClass;
        $assets->fields = new \stdClass;
        $assets->fields->title = new \stdClass;
        $assets->fields->title->{'en-US'} = $request->title;
        $assets->fields->description = new \stdClass;
        $assets->fields->description->{'en-US'} = $request->description;
        $assets->fields->file = new \stdClass;
        $assets->fields->file->{'en-US'} = new \stdClass;
        if ($extension == 'png') {
            $assets->fields->file->{'en-US'}->contentType = "image/png";
        }else if($extension == 'jpg'){
            $assets->fields->file->{'en-US'}->contentType = "image/jpg";
        }else{
            $assets->fields->file->{'en-US'}->contentType = "image/jpeg";
        }
        $assets->fields->file->{'en-US'}->fileName = $filename;
        $assets->fields->file->{'en-US'}->uploadFrom = new \stdClass;
        $assets->fields->file->{'en-US'}->uploadFrom->sys = new \stdClass;
        $assets->fields->file->{'en-US'}->uploadFrom->sys->type = 'Link';
        $assets->fields->file->{'en-US'}->uploadFrom->sys->linkType = 'Upload';
        $assets->fields->file->{'en-US'}->uploadFrom->sys->id = $uploadRes->sys->id;

        $assetsId = $request->id;
        $version = intval($request->version);
        //update assets
        $response = Http::withBody(json_encode($assets), 'application/vnd.contentful.management.v1+json')
        ->withHeaders([
            'Content-Type' => 'application/vnd.contentful.management.v1+json',
            'X-Contentful-Version' => $version
        ])
        ->withToken(config('app.cmaaccesstoken'))
        ->put(getCtUrl().'/assets/'.$assetsId);
        // Process Asset
        $response = Http::withHeaders([
            'X-Contentful-Version' => $response->json('sys.version')
        ])
        ->withToken(config('app.cmaaccesstoken'))
        ->put(getCtUrl().'/assets/'.$assetsId.'/files/en-US/process');
        return ['result'=>true];
    }

    function published(Request $request) {
        foreach(explode(',', $request->id) as $id){
            $response = Http::withToken(config('app.cmaaccesstoken'))
            ->get(getCtUrl().'/assets/'.$id);
            // Published Assets
            $response = Http::withHeaders([
                'X-Contentful-Version' => $response->json('sys.version')
            ])
            ->withToken(config('app.cmaaccesstoken'))
            ->put(getCtUrl().'/assets/'.$id.'/published');
        }
        return ['result'=>true];
    }

    function unpublished(Request $request) {
        foreach(explode(',', $request->id) as $id){
            $response = Http::withToken(config('app.cmaaccesstoken'))
            ->get(getCtUrl().'/assets/'.$id);
            // Published Assets
            $response = Http::withHeaders([
                'X-Contentful-Version' => $response->json('sys.version')
            ])
            ->withToken(config('app.cmaaccesstoken'))
            ->delete(getCtUrl().'/assets/'.$id.'/published');
        }
        return ['result'=>true];
    }

    function archived(Request $request) {
        foreach(explode(',', $request->id) as $id){
            $response = Http::withToken(config('app.cmaaccesstoken'))
            ->get(getCtUrl().'/assets/'.$id);
            // Published Assets
            $response = Http::withHeaders([
                'X-Contentful-Version' => $response->json('sys.version')
            ])
            ->withToken(config('app.cmaaccesstoken'))
            ->put(getCtUrl().'/assets/'.$id.'/archived');
        }
        return ['result'=>true];
    }

    function unarchived(Request $request) {
        foreach(explode(',', $request->id) as $id){
            $response = Http::withToken(config('app.cmaaccesstoken'))
            ->get(getCtUrl().'/assets/'.$id);
            // Published Assets
            $response = Http::withHeaders([
                'X-Contentful-Version' => $response->json('sys.version')
            ])
            ->withToken(config('app.cmaaccesstoken'))
            ->delete(getCtUrl().'/assets/'.$id.'/archived');
        }
        return ['result'=>true];
    }

    function delete(Request $request) {
        foreach(explode(',', $request->id) as $id){
            //get data
            $response = Http::withToken(config('app.cmaaccesstoken'))
            ->get(getCtUrl().'/assets/'.$id);
            $data = $response->object();
            $version = $data->sys->version;
            if(isset($data->sys->publishedAt)){
                // Published Assets
                $updateResponse = Http::withHeaders([
                    'X-Contentful-Version' => $version
                ])
                ->withToken(config('app.cmaaccesstoken'))
                ->delete(getCtUrl().'/assets/'.$id.'/published');
                $version = $updateResponse->json('sys.version');
            }else{
                if(isset($item->sys->archivedAt)){
                    $data->status = 'archive';
                }
            }
            $deleteResponse = Http::withHeaders([
                'X-Contentful-Version' => $version
            ])
            ->withToken(config('app.cmaaccesstoken'))
            ->delete(getCtUrl().'/assets/'.$id);
        }
        return ['result'=>true];
    }

    function uploadprofile(Request $request) {
        $uploadedFile = $request->file('fileupload');
        $filenameElements = explode('.', $uploadedFile->getClientOriginalName());
        $extension = array_pop($filenameElements);
        $filename = implode('.', $filenameElements);
        // upload
        $fp = fopen($uploadedFile, 'r');
        $ReadBinary = fread($fp,filesize($uploadedFile ));
        fclose($fp);
        $FileData = addslashes($ReadBinary);
        $response = Http::withBody(
            $ReadBinary, 'application/octet-stream'
        )
        ->withHeaders(['Content-Type' => 'application/octet-stream'])
        ->withToken(config('app.cmaaccesstoken'))
        ->post('https://'.config('app.uploadurl').'/spaces/'.config('app.spaceid').'/uploads');
        $uploadRes = $response->object();
        //Tags Object
        $profiletag = new \stdClass;
        $profiletag->sys = new \stdClass;
        $profiletag->sys->type = "Link";
        $profiletag->sys->linkType = "Tag";
        $profiletag->sys->id = "profileimage";
        // Create Assets
        $assets = new \stdClass;
        //Tags
        $assets->metadata = new \stdClass;
        $assets->metadata->tags = [];
        array_push($assets->metadata->tags,$profiletag);
        $assets->fields = new \stdClass;
        $assets->fields->title = new \stdClass;
        $assets->fields->title->{'en-US'} = $request->title;
        $assets->fields->description = new \stdClass;
        $assets->fields->description->{'en-US'} = $request->description;
        $assets->fields->file = new \stdClass;
        $assets->fields->file->{'en-US'} = new \stdClass;
        if ($extension == 'png') {
            $assets->fields->file->{'en-US'}->contentType = "image/png";
        }else if($extension == 'jpg'){
            $assets->fields->file->{'en-US'}->contentType = "image/jpg";
        }else{
            $assets->fields->file->{'en-US'}->contentType = "image/jpeg";
        }
        $assets->fields->file->{'en-US'}->fileName = $filename;
        $assets->fields->file->{'en-US'}->uploadFrom = new \stdClass;
        $assets->fields->file->{'en-US'}->uploadFrom->sys = new \stdClass;
        $assets->fields->file->{'en-US'}->uploadFrom->sys->type = 'Link';
        $assets->fields->file->{'en-US'}->uploadFrom->sys->linkType = 'Upload';
        $assets->fields->file->{'en-US'}->uploadFrom->sys->id = $uploadRes->sys->id;
        $assetsId = '';
        $assetsVersion = 0;
        if($request->mid)
        {
            $assetsId = $request->mid;
            $assetsVersion = intval($request->mversion);
            $response = Http::withBody(json_encode($assets), 'application/vnd.contentful.management.v1+json')
            ->withHeaders([
                'Content-Type' => 'application/vnd.contentful.management.v1+json',
                'X-Contentful-Version' => $assetsVersion
            ])
            ->withToken(config('app.cmaaccesstoken'))
            ->put(getCtUrl().'/assets/'.$assetsId);
        }else{
            $response = Http::withBody(json_encode($assets), 'application/vnd.contentful.management.v1+json')
            ->withToken(config('app.cmaaccesstoken'))
            ->post(getCtUrl().'/assets');
            $assetsId = $response->json('sys.id');
            $assetsVersion = intval($response->json('sys.version'));
        }
        // Process Asset
        $response = Http::withHeaders([
            'X-Contentful-Version' => $assetsVersion
        ])
        ->withToken(config('app.cmaaccesstoken'))
        ->put(getCtUrl().'/assets/'.$assetsId.'/files/en-US/process');
        if($response->status() <> 204){
            return false;
        }
        $response = Http::withToken(config('app.cmaaccesstoken'))
        ->get(getCtUrl().'/assets/'.$assetsId);
        // Published Assets
        $response = Http::withHeaders([
            'X-Contentful-Version' => $response->json('sys.version')
        ])
        ->withToken(config('app.cmaaccesstoken'))
        ->put(getCtUrl().'/assets/'.$assetsId.'/published');
        $resObj = $response->object();
        $result = new \stdClass;
        $result->id = $resObj->sys->id;
        $result->version = $resObj->sys->version;
        $result->title = $resObj->fields->title->{'en-US'};
        $result->description = $resObj->fields->description->{'en-US'};
        $result->url = 'https:'.$resObj->fields->file->{'en-US'}->url;
        //public all draft
        $arrayquery = array("mimetype_group"=>"image");
        $arrayquery['sys.publishedAt[exists]'] = 'false';
        $arrayquery['metadata.tags.sys.id[nin]'] = 'profileimage';
        $response = Http::withToken(config('app.cmaaccesstoken'))
        ->get(getCtUrl().'/assets',$arrayquery);
        $resObj = $response->object();
        foreach($resObj->items as $item){
            $response = Http::withHeaders([
                'X-Contentful-Version' => $item->sys->version
            ])
            ->withToken(config('app.cmaaccesstoken'))
            ->put(getCtUrl().'/assets/'.$item->sys->id.'/published');
        }
        return $result;
    }

    function list(Request $request) {
        $columns = array(
            0 => 'fields.id',
            1 => 'fields.file',
            2 => 'fields.title',
            3 => 'sys.createdAt'
        );


        $limit = $request->input('length');
        $start = $request->input('start');


        $search = $request->input('search.value');

        $fieldorder = $columns[$request->input('order.0.column')];
        if($request->input('order.0.dir') == 'desc'){
            $fieldorder = '-'.$fieldorder;
        }

        $arrayquery = array("mimetype_group"=>"image");
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
        // $arrayquery['metadata.tags.sys.id[nin]'] = 'profileimage,defaultimage';
        $arrayquery['order'] = $fieldorder;
        $arrayquery['limit'] = $limit;
        $arrayquery['skip'] = $start;

        $response = Http::withToken(config('app.cmaaccesstoken'))
        ->get(getCtUrl().'/assets',$arrayquery);

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
            $data->file = 'https:'.$item->fields->file->{'en-US'}->url;
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
            $data->updatetool = true;
            switch($data->status){
                case 'publish':
                    $data->unpublishtool = true;
                    break;
                case 'change':
                    $data->publishtool = true;
                    $data->unpublishtool = true;
                    break;
                case 'draft':
                    $data->publishtool = true;
                    $data->archivetool = true;
                    $data->deletetool = true;
                    break;
                case 'archive':
                    $data->deletetool = true;
                    $data->unarchivetool = true;
                    break;
            }
            array_push($result->data,$data);
        }
        // return authuser();
        return $result;
    }
}
