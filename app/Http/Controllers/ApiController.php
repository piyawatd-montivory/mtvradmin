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
            $skillarrayquery = array("content_type"=>"position");
            $skillarrayquery['fields.active'] = "true";
            $skillarrayquery['fields.skills[in]'] = "";
            foreach($request->skill as $skill){
                if($skillarrayquery['fields.skills[in]'] != ''){
                    $skillarrayquery['fields.skills[in]'] = $skillarrayquery['fields.skills[in]'].','.$skill;
                }else{
                    $skillarrayquery['fields.skills[in]'] = $skill;
                }
            }
            $skillarrayquery['order'] = "fields.title";
            $skillresponse = Http::withToken(config('app.cdaaccesstoken'))
            ->get(getCtCdaUrl().'/entries',$skillarrayquery);
            $skillResult = $skillresponse->object();
            $skills = $skillResult->items;
        }
        $interests = [];
        if($request->interest){
            $interestarrayquery = array("content_type"=>"position");
            $interestarrayquery['fields.active'] = "true";
            $interestarrayquery['fields.interests[in]'] = "";
            foreach($request->interest as $interest){
                if($interestarrayquery['fields.interests[in]'] != ''){
                    $interestarrayquery['fields.interests[in]'] = $interestarrayquery['fields.interests[in]'].','.$interest;
                }else{
                    $interestarrayquery['fields.interests[in]'] = $interest;
                }
            }
            $interestarrayquery['order'] = "fields.title";
            $interestresponse = Http::withToken(config('app.cdaaccesstoken'))
            ->get(getCtCdaUrl().'/entries',$interestarrayquery);
            $interestResult = $interestresponse->object();
            $interests = $interestResult->items;
        }
        $results = [];
        foreach($skills as $skill){
            $job = new \stdClass;
            $job->id = $skill->sys->id;
            $job->title = $skill->fields->title;
            $job->slug = $skill->fields->slug;
            $job->excerpt = $skill->fields->excerpt;
            $job->description = $skill->fields->description;
            array_push($results,$job);
        }
        foreach($interests as $interest){
            $pass = true;
            foreach($skills as $skill){
                if($interest->sys->id == $skill->sys->id){
                    $pass = false;
                    break;
                }
            }
            if($pass){
                $job = new \stdClass;
                $job->id = $interest->sys->id;
                $job->title = $interest->fields->title;
                $job->slug = $interest->fields->slug;
                $job->excerpt = $interest->fields->excerpt;
                $job->description = $interest->fields->description;
                array_push($results,$job);
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
        $contact = new \stdClass;
        $contact->fields = new \stdClass;
        $contact->fields->contacttype = new \stdClass;
        $contact->fields->contacttype->{'en-US'} = $request->type;
        $contact->fields->fullname = new \stdClass;
        $contact->fields->fullname->{'en-US'} = $request->fullname;
        if($request->position <> 'other'){
            $posObj = new \stdClass;
            $posObj->sys = new \stdClass;
            $posObj->sys->type = "Link";
            $posObj->sys->linkType = "Entry";
            $posObj->sys->id = $request->position;
            $contact->fields->position = new \stdClass;
            $contact->fields->position->{'en-US'} = $posObj;
        }
        $contact->fields->company = new \stdClass;
        $contact->fields->company->{'en-US'} = $request->company;
        $contact->fields->phone = new \stdClass;
        $contact->fields->phone->{'en-US'} = $request->phone;
        $contact->fields->email = new \stdClass;
        $contact->fields->email->{'en-US'} = $request->email;
        $contact->fields->cv = new \stdClass;
        $contact->fields->cv->{'en-US'} = $path.$filename;
        $contact->fields->message = new \stdClass;
        $contact->fields->message->{'en-US'} = $request->message;
        $contact->fields->sendemail = new \stdClass;
        $contact->fields->sendemail->{'en-US'} = false;
        $contact->fields->read = new \stdClass;
        $contact->fields->read->{'en-US'} = false;
        $response = Http::withBody(json_encode($contact), 'application/vnd.contentful.management.v1+json')
        ->withHeaders([
            'X-Contentful-Content-Type' => 'contact',
            'Content-Type' => 'application/vnd.contentful.management.v1+json'
        ])
        ->withToken(config('app.cmaaccesstoken'))
        ->post(getCtUrl().'/entries');
        return ['result'=>true];
    }

    function contact(Request $request){
        $contact = new \stdClass;
        $contact->fields = new \stdClass;
        $contact->fields->contacttype = new \stdClass;
        $contact->fields->contacttype->{'en-US'} = $request->type;
        $contact->fields->fullname = new \stdClass;
        $contact->fields->fullname->{'en-US'} = $request->fullname;
        $contact->fields->company = new \stdClass;
        $contact->fields->company->{'en-US'} = $request->company;
        $contact->fields->phone = new \stdClass;
        $contact->fields->phone->{'en-US'} = $request->phone;
        $contact->fields->email = new \stdClass;
        $contact->fields->email->{'en-US'} = $request->email;
        $contact->fields->message = new \stdClass;
        $contact->fields->message->{'en-US'} = $request->message;
        $contact->fields->sendemail = new \stdClass;
        $contact->fields->sendemail->{'en-US'} = false;
        $contact->fields->read = new \stdClass;
        $contact->fields->read->{'en-US'} = false;
        $response = Http::withBody(json_encode($contact), 'application/vnd.contentful.management.v1+json')
        ->withHeaders([
            'X-Contentful-Content-Type' => 'contact',
            'Content-Type' => 'application/vnd.contentful.management.v1+json'
        ])
        ->withToken(config('app.cmaaccesstoken'))
        ->post(getCtUrl().'/entries');
        return ['result'=>true];
    }
}
?>


