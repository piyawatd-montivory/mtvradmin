<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Position;
use App\Models\SkillInterest;
use App\Models\PositionSkill;
use Illuminate\Http\Request;

class PositionController extends Controller
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
        return view('admins.position.index');
    }
    public function new()
    {
        $position = new Position();
        $position->status_active = true;
        $skills = SkillInterest::where('type','skill')
        ->orderBy('name', 'asc')->get();
        $interests = SkillInterest::where('type','interest')
        ->orderBy('name', 'asc')->get();
        return view('admins.position.form', [ 'position' => $position,'positionskills'=>[],'skills'=>$skills,'interests'=>$interests]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $position = new Position();
        $this->updateDatabase($position, $request,'new');
        return redirect()->route('positionindex')->with('success', 'Position saved!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $skills = SkillInterest::where('type','skill')
        ->orderBy('name', 'asc')->get();
        $interests = SkillInterest::where('type','interest')
        ->orderBy('name', 'asc')->get();
        $posSkill = PositionSkill::where('position',$id)->get();
        return view('admins.position.form', [ 'position' => Position::find($id),'positionskills'=>$posSkill,'skills'=>$skills,'interests'=>$interests]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $position = Position::find($id);
        $this->updateDatabase($position, $request,'edit');
        return redirect()->route('positionindex')->with('success', 'Position updated!');
    }

    public function updateDatabase(Position $position, Request $request,$mode)
    {
        $position->position = $request->position;
        $position->alias = $request->alias;
        $position->short_description = $request->short_description;
        $position->description = $request->description;
        $position->status_active = $request->status_active?:false;
        if($request->image){
            $position->image = $request->image;
        }
        $position->og_title = $request->og_title;
        $position->og_description = $request->og_description;
        $position->og_image = $request->og_image;
        $position->og_locale = $request->og_locale;
        $position->fb_pages = $request->fb_pages;
        $position->fb_app_id = $request->fb_app_id;
        $position->fb_image = $request->fb_image;
        $position->twitter_image = $request->twitter_image;
        $position->save();
        $positionskill = PositionSkill::where('position',$position->id)->delete();
        if($request->skillid){
            foreach($request->skillid as $key=>$value){
                $positionskill = new PositionSkill();
                $positionskill->position = $position->id;
                $positionskill->skill = $request->skillid[$key];
                $positionskill->save();
            }
        }
        if($request->interestid){
            foreach($request->interestid as $key=>$value){
                $positionskill = new PositionSkill();
                $positionskill->position = $position->id;
                $positionskill->interest = $request->interestid[$key];
                $positionskill->save();
            }
        }
    }

    public function delete($id, Request $request)
    {
        $position = Position::find($id)->delete();
        return ['result'=>true];
    }

    public function list(Request $request)
    {
        // https://shareurcodes.com/blog/laravel%20datatables%20server%20side%20processing
        $columns = array(
            0 => 'position',
            1 => 'short_description',
            2 => 'description',
            3 => 'status_active',
            4 => 'image',
            5 => 'og_title',
            6 => 'og_description',
            7 => 'og_image',
            8 => 'og_locale',
            9 => 'fb_pages',
            10 => 'fb_app_id',
            11 => 'fb_image',
            12 => 'twitter_image',
        );

        $totalData = Position::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $search = $request->input('search.value');

        $positions = Position::where('position', 'LIKE', "%{$search}%")
             ->offset($start)
             ->limit($limit)
             ->orderBy($order, $dir)
            ->get();

        $totalFiltered = Position::where('position', 'LIKE', "%{$search}%")
            ->count();

        $data = array();
        if (!empty($positions)) {
            foreach ($positions as $position) {
                $nestedData['id'] = $position->id;
                $nestedData['position'] = $position->position;
                $nestedData['short_description'] = $position->short_description;
                $nestedData['description'] = $position->description;
                $nestedData['status_active'] = $position->status_active;
                $nestedData['image'] = $position->image;
                $nestedData['og_title'] = $position->og_title;
                $nestedData['og_description'] = $position->og_description;
                $nestedData['og_image'] = $position->og_image;
                $nestedData['og_locale'] = $position->og_locale;
                $nestedData['fb_pages'] = $position->fb_pages;
                $nestedData['fb_app_id'] = $position->fb_app_id;
                $nestedData['fb_image'] = $position->fb_image;
                $nestedData['twitter_image'] = $position->twitter_image;
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
