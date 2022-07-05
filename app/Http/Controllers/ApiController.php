<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Response;
use App\Models\Position;
use App\Models\SkillInterest;
use App\Models\PositionSkill;

class ApiController extends Controller
{
    function position(Request $request)
    {
        //skill
        $skills = [];
        if($request->skill){
            $skills = PositionSkill::join('positions','positions.id','=','position_skills.position')
        ->whereIn('skill',$request->skill)->get();
        }
        $interests = [];
        if($request->interest){
            $interests = PositionSkill::join('positions','positions.id','=','position_skills.position')
            ->whereIn('interest',$request->interest)->get();
        }
        $results = [];
        foreach($skills as $skill){
            $job = new \stdClass;
            $job->id = $skill->id;
            $job->position = $skill->position;
            $job->short_description = $skill->short_description;
            $job->description = $skill->description;
            array_push($results,$job);
        }
        foreach($interests as $interest){
            $pass = true;
            foreach($skills as $skill){
                if($interest->id == $skill->id){
                    $pass = false;
                    break;
                }
            }
            if($pass){
                $job = new \stdClass;
                $job->id = $skill->id;
                $job->position = $skill->position;
                $job->short_description = $skill->short_description;
                $job->description = $skill->description;
                array_push($results,$job);
            }
        }

        return ['total'=>count($results),'data'=>$results];
    }
}
?>


