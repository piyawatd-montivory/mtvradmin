<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\TeamMontivory;
use Illuminate\Http\Request;

class MontivoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admins.montivory.index',['teams'=>TeamMontivory::orderBy('sortorder','asc')->get()]);
    }
    public function new()
    {
        $montivory = new TeamMontivory();
        $montivory->linkedin_active = true;
        $montivory->status_active = true;
        $montivory->sortorder = TeamMontivory::max('sortorder') + 1;
        return view('admins.montivory.form', [ 'montivory' => $montivory]);
    }

    public function reorder(Request $request)
    {
        foreach($request->id as $key=>$value){
            $montivory = TeamMontivory::find($value);
            $montivory->sortorder = $key + 1;
            $montivory->save();
        }
        return ['result'=>true];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $montivory = new TeamMontivory();
        $this->updateDatabase($montivory, $request,'new');
        return redirect()->route('montivoryindex')->with('success', 'Team Montivory saved!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SkillInterest  $skillInterest
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admins.montivory.form', [ 'montivory' => TeamMontivory::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SkillInterest  $skillInterest
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $montivory = TeamMontivory::find($id);
        $this->updateDatabase($montivory, $request,'edit');
        return redirect()->route('montivoryindex')->with('success', 'Team Montivory updated!');
    }

    public function updateDatabase(TeamMontivory $montivory, Request $request,$mode)
    {
        $montivory->firstname = $request->firstname;
        $montivory->lastname = $request->lastname;
        if($request->image){
            $montivory->image = $request->image;
        }
        $montivory->job_position = $request->job_position;
        $montivory->linkedin_url = $request->linkin_url;
        $montivory->linkedin_url = $request->linkin_url;
        $montivory->sortorder = $request->sortorder;
        $montivory->linkedin_active = ($request->linkin_active) ? true:false;
        $montivory->status_active = ($request->status_active) ? true:false;
        $montivory->save();
    }

    public function delete($id, Request $request)
    {
        $montivory = TeamMontivory::find($id)->delete();
        return ['result'=>true];
    }

    public function list(Request $request)
    {
        // https://shareurcodes.com/blog/laravel%20datatables%20server%20side%20processing
        $columns = array(
            0 => 'firstname',
            1 => 'lastname',
            2 => 'job_position',
            3 => 'status_active',
        );

        $totalData = TeamMontivory::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $search = $request->input('search.value');

        $montivories = TeamMontivory::where('firstname', 'LIKE', "%{$search}%")
             ->offset($start)
             ->limit($limit)
             ->orderBy($order, $dir)
            ->get();

        $totalFiltered = TeamMontivory::where('firstname', 'LIKE', "%{$search}%")
            ->count();

        $data = array();

        if (!empty($montivories)) {
            foreach ($montivories as $montivory) {
                $nestedData['id'] = $montivory->id;
                $nestedData['firstname'] = $montivory->firstname;
                $nestedData['lastname'] = $montivory->lastname;
                $nestedData['job_position'] = $montivory->job_position;
                if($montivory->status_active){
                    $nestedData['status_active'] = true;
                }else{
                    $nestedData['status_active'] = false;
                }
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
