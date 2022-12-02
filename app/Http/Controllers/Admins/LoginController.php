<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Response;
use Session;

class LoginController extends Controller
{
    function signin()
    {
        return view('admins.login.signin');
    }

    function auth(Request $request)
    {
        $arrayquery = array("content_type"=>"user");
        $arrayquery['fields.email'] = $request->email;
        $response = Http::withToken(config('app.cmaaccesstoken'))
        ->get(getCtUrl().'/entries',$arrayquery);
        $resObj = $response->object();
        if($resObj->total == 0){
            return ['result'=>false,'message'=>'Not found email'];
        }
        $user = $resObj->items[0];
        if(!Hash::check($request->password, $user->fields->password->{'en-US'})){
            return ['result'=>false,'message'=>'Wrong password'];
        }
        if(!$user->fields->active->{'en-US'}){
            return ['result'=>false,'message'=>'You account is not active.'];
        }
        $result = getProfile($user->sys->id);
        return ['result'=>true,'user'=>$result];
    }

    function signout(Request $request)
    {
        Session::forget('user');
        return ['result'=>true];
    }
}
?>
