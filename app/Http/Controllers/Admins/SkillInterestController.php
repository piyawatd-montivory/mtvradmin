<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\SkillInterest;
use Illuminate\Http\Request;

class SkillInterestController extends Controller
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
        return view('admins.skill.index');
    }
    public function new()
    {
        $skill = new SkillInterest();
        return view('admins.skill.form', [ 'skill' => $skill]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $skill = new SkillInterest();
        $this->updateDatabase($skill, $request,'new');
        return redirect()->route('skillindex')->with('success', 'Skill saved!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SkillInterest  $skillInterest
     * @return \Illuminate\Http\Response
     */
    public function show(SkillInterest $skillInterest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SkillInterest  $skillInterest
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admins.skill.form', [ 'skill' => SkillInterest::find($id)]);
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
        $skill = SkillInterest::find($id);
        $this->updateDatabase($skill, $request,'edit');
        return redirect()->route('skillindex')->with('success', 'Skill updated!');
    }

    public function updateDatabase(SkillInterest $skill, Request $request,$mode)
    {
        $skill->name = $request->name;
        $skill->type = $request->type;
        $skill->save();
    }

    public function delete($id, Request $request)
    {
        $skill = SkillInterest::find($id)->delete();
        return ['result'=>true];
    }

    public function list(Request $request)
    {
        // https://shareurcodes.com/blog/laravel%20datatables%20server%20side%20processing
        $columns = array(
            0 => 'name',
            1 => 'type',
        );

        $totalData = SkillInterest::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $search = $request->input('search.value');

        $skills = SkillInterest::where('name', 'LIKE', "%{$search}%")
             ->offset($start)
             ->limit($limit)
             ->orderBy($order, $dir)
            ->get();

        $totalFiltered = SkillInterest::where('name', 'LIKE', "%{$search}%")
            ->count();

        $data = array();

        if (!empty($skills)) {
            foreach ($skills as $skill) {
                $nestedData['id'] = $skill->id;
                $nestedData['name'] = $skill->name;
                $nestedData['type'] = $skill->type;
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
