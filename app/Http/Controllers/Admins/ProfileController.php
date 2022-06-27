<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Response;

class ProfileController extends Controller
{
    function index()
    {
        // $response = Http::withBasicAuth(config('app.ctclient'),config('app.ctsecret'))->post(config('app.ctoauth').'/oauth/token?grant_type=client_credentials');
        // $response->json('access_token')
        // $token = 'x6-7glbLfWBG_z73wJhHxn2gjQKJNg1N';
        // $response = Http::withBasicAuth(config('app.ctclient'),config('app.ctsecret'))->withHeaders([
        //     'Authorization' => 'Basic '.$token,
        // ])->post(config('app.ctoauth').'/oauth/'.config('app.ctproject').'/customers/token?grant_type=password&username=arunwatd@gmail.com&password=xbp;y<oN');

        // $logintoken = 'SYfjpfavOXz6gcDrS3nngGu6CYG_2qBi';
        // $response = Http::withHeaders([
        //     'Authorization' => 'Bearer '.$logintoken,
        // ])->get(config('app.cturl').'/'.config('app.ctproject').'/products??where=masterData(current(masterVariant(attributes(name%3D%22seller%22%20and%20value%3D%22arunwatd%40gmail.com%22))))');
        // return $response->json();
        $logintoken = 'SYfjpfavOXz6gcDrS3nngGu6CYG_2qBi';
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$logintoken,
        ])->get(config('app.cturl').'/'.config('app.ctproject').'/me');
        return $response->body();
    }
}
?>


