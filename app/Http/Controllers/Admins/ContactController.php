<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\Contact;
use App\Models\Position;
use Datetime;
use DateTimeZone;
use Auth;


class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admins.contact.index');
    }

    public function view($id)
    {
        $contact = Contact::find($id);
        $contact->flagread = true;
        $contact->save();
        $position = '';
        if($contact->contact_type == 'job'){
            $position = 'Other';
            if($contact->select_position){
                $posObj = Position::find($contact->select_position);
                $position = $posObj->position;
            }
        }
        return view('admins.contact.view', [ 'contact' => $contact,'position'=> $position]);
    }

    public function list(Request $request)
    {
        $columns = array(
            0 => 'fullname',
            1 => 'email',
            2 => 'phone',
            3 => 'created_at'
        );

        $totalData = Contact::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');


        $search = $request->input('search.value');

        $contacts = Contact::where('contact_type',$request->type)
            ->where(function ($query) use ($search) {
                $query->where('fullname', 'LIKE',"%{$search}%")
                ->orWhere('email', 'LIKE',"%{$search}%")
                ->orWhere('phone', 'LIKE',"%{$search}%");
            })
            ->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $totalFiltered = Contact::where('contact_type',$request->type)
            ->where(function ($query) use ($search) {
                $query->where('fullname', 'LIKE',"%{$search}%")
                ->orWhere('email', 'LIKE',"%{$search}%")
                ->orWhere('phone', 'LIKE',"%{$search}%");
            })
            ->count();

        $data = array();
        if (!empty($contacts)) {
            foreach ($contacts as $contact) {
                $date = new Datetime($contact->created_at);
                $date->setTimezone(new DateTimeZone('+7.0'));
                $nestedData['id'] = $contact->id;
                $nestedData['fullname'] = $contact->fullname;
                $nestedData['email'] = $contact->email;
                $nestedData['phone'] = $contact->phone;
                if($contact->flagread){
                    $nestedData['flagread'] = true;
                }else{
                    $nestedData['flagread'] = false;
                }
                $nestedData['date'] = date_format($date,'d/m/Y H:i');
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        return $json_data;
    }
}
