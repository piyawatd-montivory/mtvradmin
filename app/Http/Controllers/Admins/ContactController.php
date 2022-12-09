<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->contenttypeid = 'contact';
    }

    public function index()
    {
        return view('admins.contact.index');
    }

    public function view($id)
    {
        $response = Http::withToken(config('app.cmaaccesstoken'))
        ->get(getCtUrl().'/entries/'.$id.'/references?include=10');
        $resObj = $response->object();
        $data = new \stdClass;
        $refsEntry = isset($resObj->includes->Entry)?$resObj->includes->Entry:[];
        if(!$resObj->items[0]->fields->read->{'en-US'}){
            $json = new \stdClass;
            $json->fields = $resObj->items[0]->fields;
            $json->fields->read->{'en-US'} = true;
            //update read
            $response = Http::withBody(json_encode($json), 'application/vnd.contentful.management.v1+json')
            ->withHeaders([
                'X-Contentful-Content-Type' => $this->contenttypeid,
                'Content-Type' => 'application/vnd.contentful.management.v1+json',
                'X-Contentful-Version' => intval($resObj->items[0]->sys->version)
            ])
            ->withToken(config('app.cmaaccesstoken'))
            ->put(getCtUrl().'/entries/'.$id);
        }
        $data->id = $resObj->items[0]->sys->id;
        $data->version = $resObj->items[0]->sys->version;
        $data->fullname = $resObj->items[0]->fields->fullname->{'en-US'};
        $data->email = $resObj->items[0]->fields->email->{'en-US'};
        $data->phone = $resObj->items[0]->fields->phone->{'en-US'};
        $data->cv = $resObj->items[0]->fields->cv->{'en-US'};
        $data->company = $resObj->items[0]->fields->company->{'en-US'};
        $data->message = $resObj->items[0]->fields->message->{'en-US'};
        $data->contacttype = $resObj->items[0]->fields->contacttype->{'en-US'};
        $createAt = explode(".",$resObj->items[0]->sys->createdAt);
        $dt = date_create_from_format('Y-m-d\TH:i:s', $createAt[0]);
        date_add($dt,date_interval_create_from_date_string("7 hours"));
        $data->createat = date_format($dt,"d / m / Y H:i");
        $data->position = 'Other';
        if($data->contacttype == 'job'){
            if(isset($resObj->items[0]->fields->position)){
                foreach($refsEntry as $item){
                    if($item->sys->id == $resObj->items[0]->fields->position->{'en-US'}->sys->id){
                        $data->position = $item->fields->title->{'en-US'};
                        break;
                    }
                }
            }
        }
        return view('admins.contact.view', [ 'contact' => $data]);
    }

    public function list(Request $request){
        $columns = array(
            0 => 'fields.fullname',
            1 => 'fields.email',
            2 => 'fields.phone',
            3 => 'sys.createdAt',
        );

        $limit = $request->input('length');
        $start = $request->input('start');


        $search = $request->input('search.value');

        $fieldorder = $columns[$request->input('order.0.column')];
        if($request->input('order.0.dir') == 'desc'){
            $fieldorder = '-'.$fieldorder;
        }

        $arrayquery = array("content_type"=>$this->contenttypeid);
        $arrayquery['fields.contacttype'] = $request->type;
        $arrayquery['select'] = 'sys.id,sys.createdAt,sys.version,fields.fullname,fields.phone,fields.email,fields.contacttype,fields.read';
        if($search <> ''){
            $arrayquery['query'] = $search;
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
        $uPermission = authuser()->permission;
        foreach($resObj->items as $item) {
            // $date = new Datetime($contact->created_at);
            // $date->setTimezone(new DateTimeZone('+7.0'));
            $createAt = explode(".",$item->sys->createdAt);
            $dt = date_create_from_format('Y-m-d\TH:i:s', $createAt[0]);
            date_add($dt,date_interval_create_from_date_string("7 hours"));
            $data = new \stdClass;
            $data->id = $item->sys->id;
            $data->version = $item->sys->version;
            $data->fullname = $item->fields->fullname->{'en-US'};
            $data->email = $item->fields->email->{'en-US'};
            $data->phone = $item->fields->phone->{'en-US'};
            $data->createat = date_format($dt,"d / m / Y H:i");
            $data->read = $item->fields->read->{'en-US'};
            array_push($result->data,$data);
        }
        // return authuser();
        return $result;
    }
}
