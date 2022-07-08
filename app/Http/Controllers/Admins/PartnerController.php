<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\Partner;
use Auth;


class PartnerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admins.partner.index',['partners'=>Partner::orderBy('sortorder','asc')->get()]);
    }

    public function new()
    {
        $partner = new Partner();
        $partner->sortorder = Partner::max('sortorder') + 1;
        return view('admins.partner.form', [ 'partner' => $partner]);
    }

    public function reorder(Request $request)
    {
        foreach($request->id as $key=>$value){
            $partner = Partner::find($value);
            $partner->sortorder = $key + 1;
            $partner->save();
        }
        return ['result'=>true];
    }

    public function edit($id)
    {
        return view('admins.partner.form', [ 'partner' => Partner::find($id)]);
    }

    public function create(Request $request)
    {
        $partner = new Partner();
        $this->updateDatabase($partner, $request,'new');
        return redirect()->route('partnerindex')->with('success', 'Partner saved!');
    }

    public function update($id, Request $request)
    {
        $partner = Partner::find($id);
        $this->updateDatabase($partner, $request,'edit');
        return redirect()->route('partnerindex')->with('success', 'Partner updated!');
    }

    public function updateDatabase(Partner $partner, Request $request,$mode)
    {
        if(!empty($request->logo)){
            $partner->logo = $request->logo;
        }
        $partner->name = $request->name;
        $partner->description = $request->description;
        $partner->url = $request->url;
        $partner->sortorder = $request->sortorder;
        $partner->save();
    }

    public function delete($id, Request $request)
    {
        $partner = Partner::find($id)->delete();
        return ['result'=>true];
    }

    public function list(Request $request)
    {
        // https://shareurcodes.com/blog/laravel%20datatables%20server%20side%20processing
        $columns = array(
            0 => 'logo',
            1 => 'name',
            2 => 'sortorder',
        );

        $totalData = Partner::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');


        $search = $request->input('search.value');

        $partners = Partner::where('name', 'LIKE', "%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $totalFiltered = Partner::where('name', 'LIKE', "%{$search}%")
            ->count();

        $data = array();
        if (!empty($partners)) {
            foreach ($partners as $partner) {
                $nestedData['id'] = $partner->id;
                $nestedData['logo'] = $partner->logo;
                $nestedData['name'] = $partner->name;
                $nestedData['sortorder'] = $partner->sortorder;
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
