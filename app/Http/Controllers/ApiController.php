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
use App\Models\Contact;

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
            if($skill->status_active)
            {
                $job = new \stdClass;
                $job->id = $skill->id;
                $job->position = $skill->position;
                $job->alias = $skill->alias;
                $job->short_description = $skill->short_description;
                $job->description = $skill->description;
                array_push($results,$job);
            }
        }
        foreach($interests as $interest){
            if($interest->status_active)
            {
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
                    $job->alias = $skill->alias;
                    $job->short_description = $skill->short_description;
                    $job->description = $skill->description;
                    array_push($results,$job);
                }
            }
        }

        return ['total'=>count($results),'data'=>$results];
    }

    function uploadcv(Request $request){
        $path = 'files/shares/cv/';
        $uploadedFile = $request->file('cv');
        $filename = $uploadedFile->getClientOriginalName();
        Storage::disk('local')->putFileAs(
            $path,
            $uploadedFile,
            $filename
        );
        $contact = new Contact();
        $contact->contact_type = $request->type;
        $contact->fullname = $request->fullname;
        $contact->select_position = $request->position;
        $contact->company = $request->fullname;
        $contact->phone = $request->fullname;
        $contact->email = $request->fullname;
        $contact->cv = $path.$filename;
        $contact->message = $request->message;
        $contact->status_mail = false;
        $contact->save();
        return ['result'=>true];
    }

    function contact(Request $request){
        $contact = new Contact();
        $contact->contact_type = $request->type;
        $contact->fullname = $request->fullname;
        $contact->company = $request->fullname;
        $contact->phone = $request->fullname;
        $contact->email = $request->fullname;
        $contact->message = $request->message;
        $contact->status_mail = false;
        $contact->save();
        return ['result'=>true];
    }
}
?>


